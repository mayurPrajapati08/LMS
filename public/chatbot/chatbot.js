(function () {
  const root = document.getElementById('cyi-chatbot-root');
  if (!root) {
    return;
  }

  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition || null;
  const isLocalHost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.hostname === '::1';
  const voiceInputSupported = !!SpeechRecognition && (window.isSecureContext || isLocalHost);

  const config = {
    contextUrl: root.dataset.contextUrl,
    inquiryUrl: root.dataset.inquiryUrl,
    healthUrl: root.dataset.healthUrl,
    csrfToken: root.dataset.csrfToken || '',
  };

  const state = {
    context: null,
    leadFlow: null,
    speechEnabled: 'speechSynthesis' in window,
    voiceInputSupported: voiceInputSupported,
    autoSpeak: false,
    isListening: false,
    isProcessingVoice: false,
    recognition: null,
    preferredVoice: null,
    recognitionBaseText: '',
    recognitionFinalText: '',
    recognitionInterimText: '',
    hasRecognitionResult: false,
    ignoreRecognitionEnd: false,
  };

  root.innerHTML = [
    '<div class="cyi-chatbot" data-chatbot>',
    '  <button class="cyi-chatbot__launcher" type="button" data-launcher>',
    '    <span class="cyi-chatbot__launcher-icon"><span class="material-symbols-outlined">smart_toy</span></span>',
    '    <span class="cyi-chatbot__launcher-copy">',
    '      <strong>Ask CYIS</strong>',
    '      <span>Quick Help</span>',
    '    </span>',
    '  </button>',
    '  <section class="cyi-chatbot__panel" aria-label="LMS chatbot panel">',
    '    <header class="cyi-chatbot__header">',
    '      <div class="cyi-chatbot__header-row">',
    '        <div>',
    '          <p class="cyi-chatbot__eyebrow">CodeInYourself</p>',
    '          <h2 class="cyi-chatbot__title">CYIS Assistant</h2>',
    '          <p class="cyi-chatbot__subtitle">I am here to help you with training programs, mentorship, support, and workshops.</p>',
    '          <div class="cyi-chatbot__status"><span class="cyi-chatbot__status-dot"></span><span data-health-label>Starting</span></div>',
    '        </div>',
    '        <div class="cyi-chatbot__toolbar">',
    '          <button class="cyi-chatbot__icon-button" type="button" data-new-chat aria-label="Start a new chat"><span class="material-symbols-outlined">add_comment</span></button>',
    '          <button class="cyi-chatbot__icon-button" type="button" data-speak-toggle aria-label="Turn voice replies on"><span class="material-symbols-outlined">volume_off</span></button>',
    '          <button class="cyi-chatbot__icon-button" type="button" data-close aria-label="Close chatbot"><span class="material-symbols-outlined">close</span></button>',
    '        </div>',
    '      </div>',
    '    </header>',
    '    <div class="cyi-chatbot__quick-actions" data-quick-actions></div>',
    '    <div class="cyi-chatbot__messages pretty-scroll" data-messages></div>',
    '    <footer class="cyi-chatbot__footer">',
    '      <form class="cyi-chatbot__composer" data-form>',
    '        <div class="cyi-chatbot__field" data-field>',
    '          <textarea class="cyi-chatbot__input" rows="1" placeholder="Ask anything..." data-input></textarea>',
    '          <div class="cyi-chatbot__composer-actions">',
    '            <button class="cyi-chatbot__voice" type="button" data-mic aria-label="Speak your prompt"><span class="material-symbols-outlined">mic</span></button>',
    '            <button class="cyi-chatbot__send" type="submit" aria-label="Send message"><span class="material-symbols-outlined">arrow_upward</span></button>',
    '          </div>',
    '        </div>',
    '      </form>',
    '      <div class="cyi-chatbot__hint" data-hint aria-live="polite">Press the mic to speak or type your message.</div>',
    '    </footer>',
    '  </section>',
    '</div>'
  ].join('');

  const elements = {
    shell: root.querySelector('[data-chatbot]'),
    launcher: root.querySelector('[data-launcher]'),
    newChat: root.querySelector('[data-new-chat]'),
    close: root.querySelector('[data-close]'),
    messages: root.querySelector('[data-messages]'),
    quickActions: root.querySelector('[data-quick-actions]'),
    form: root.querySelector('[data-form]'),
    field: root.querySelector('[data-field]'),
    input: root.querySelector('[data-input]'),
    mic: root.querySelector('[data-mic]'),
    hint: root.querySelector('[data-hint]'),
    healthLabel: root.querySelector('[data-health-label]'),
    speakToggle: root.querySelector('[data-speak-toggle]'),
  };

  const quickActions = [
    { label: 'Training Program', prompt: 'training program' },
    { label: 'Mentorship', prompt: 'mentorship' },
    { label: 'Workshop', prompt: 'workshops' },
    { label: 'Contact', prompt: 'contact team' },
  ];

  function getTimeGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) {
      return 'Good morning';
    }
    if (hour < 17) {
      return 'Good afternoon';
    }
    return 'Good evening';
  }

  function getCourseCollections(context) {
    return {
      online: Array.isArray(context.online_courses) ? context.online_courses : [],
      offline: Array.isArray(context.offline_courses) ? context.offline_courses : [],
    };
  }

  function getAllCourses(context) {
    const collections = getCourseCollections(context);
    return collections.online.concat(collections.offline);
  }

  function findMatchingCourses(input, context) {
    const normalizedInput = String(input || '').toLowerCase();
    return getAllCourses(context).filter(function (course) {
      return course && course.title && normalizedInput.indexOf(String(course.title).toLowerCase()) !== -1;
    });
  }

  function buildCourseSummary(course) {
    const bits = [];
    if (course.price) {
      bits.push('Price: ' + course.price);
    }
    if (course.level) {
      bits.push('Level: ' + course.level);
    }
    if (course.duration) {
      bits.push('Duration: ' + course.duration);
    }
    if (course.language) {
      bits.push('Language: ' + course.language);
    }
    if (course.campus) {
      bits.push('Campus: ' + course.campus);
    }
    if (course.schedule) {
      bits.push('Schedule: ' + course.schedule);
    }
    if (course.audience) {
      bits.push('For: ' + course.audience);
    }
    return bits.join(' | ');
  }

  function buildCourseButtons(courses, fallbackLabel, fallbackUrl) {
    const actions = [];
    (courses || []).slice(0, 3).forEach(function (course) {
      if (course && course.url) {
        actions.push({
          label: course.title.length > 22 ? course.title.slice(0, 22) + '...' : course.title,
          type: 'link',
          href: course.url
        });
      }
    });
    if (fallbackUrl) {
      actions.push({ label: fallbackLabel, type: 'link', href: fallbackUrl });
    }
    return actions;
  }

  function escapeHtml(value) {
    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function nl2br(value) {
    return escapeHtml(value).replace(/\n/g, '<br>');
  }

  function plainTextFromHtml(html) {
    const temp = document.createElement('div');
    temp.innerHTML = html;
    return (temp.textContent || temp.innerText || '').trim();
  }

  function normalizeSpeechText(text) {
    return String(text || '')
      .replace(/\s+/g, ' ')
      .replace(/\s*[:|]\s*/g, '. ')
      .replace(/\s*[/-]\s*/g, ', ')
      .replace(/\bCYI\b/g, 'C Y I')
      .replace(/\bLMS\b/g, 'L M S')
      .replace(/\bAI\b/g, 'A I')
      .replace(/([a-z])([A-Z])/g, '$1. $2')
      .replace(/([.!?])(?=[A-Za-z])/g, '$1 ')
      .replace(/,\s*,+/g, ', ')
      .replace(/\.\s*\./g, '.')
      .trim();
  }

  function setHint(text, tone) {
    elements.hint.textContent = text;
    elements.hint.classList.remove('is-active', 'is-error');
    if (tone === 'active') {
      elements.hint.classList.add('is-active');
    }
    if (tone === 'error') {
      elements.hint.classList.add('is-error');
    }
  }

  function getDefaultHint() {
    return 'Press the mic to speak or type your message.';
  }

  function getVoiceUnavailableHint() {
    if (!SpeechRecognition) {
      return 'Voice input works in supported Chrome or Edge browsers. You can still type.';
    }

    if (!window.isSecureContext && !isLocalHost) {
      return 'Voice input needs HTTPS or localhost in this browser. You can still type.';
    }

    return 'Voice input is not supported in this browser. You can still type.';
  }

  function normalizeComposerText(value) {
    return String(value || '').replace(/\s+/g, ' ').trim();
  }

  function setComposerValue(value) {
    elements.input.value = value;
    autoResizeInput();
  }

  function buildVoicePromptValue() {
    return normalizeComposerText([
      state.recognitionBaseText,
      state.recognitionFinalText,
      state.recognitionInterimText
    ].filter(Boolean).join(' '));
  }

  function resetRecognitionDraft(preserveComposer) {
    state.isProcessingVoice = false;
    state.recognitionBaseText = preserveComposer ? normalizeComposerText(elements.input.value) : '';
    state.recognitionFinalText = '';
    state.recognitionInterimText = '';
    state.hasRecognitionResult = false;
  }

  function cancelRecognition(preserveComposer) {
    state.ignoreRecognitionEnd = true;
    state.isListening = false;
    resetRecognitionDraft(preserveComposer);

    if (state.recognition) {
      try {
        state.recognition.stop();
      } catch (error) {
        // Ignore stop errors when recognition is already idle.
      }
    }

    updateMicButton();
  }

  function scrollToBottom() {
    elements.messages.scrollTop = elements.messages.scrollHeight;
  }

  function setOpen(isOpen) {
    elements.shell.classList.toggle('cyi-chatbot--open', isOpen);
    if (isOpen) {
      window.setTimeout(function () {
        elements.input.focus();
        scrollToBottom();
      }, 80);
    } else {
      if (state.isListening || state.isProcessingVoice) {
        cancelRecognition(true);
        setHint(getDefaultHint());
      }
      if ('speechSynthesis' in window) {
        window.speechSynthesis.cancel();
      }
    }
  }

  function updateHealth(label) {
    elements.healthLabel.textContent = label;
  }

  function updateSpeakButton() {
    if (!state.speechEnabled) {
      elements.speakToggle.style.display = 'none';
      return;
    }
    elements.speakToggle.classList.toggle('is-active', state.autoSpeak);
    elements.speakToggle.querySelector('.material-symbols-outlined').textContent = state.autoSpeak ? 'volume_up' : 'volume_off';
    elements.speakToggle.setAttribute('aria-label', state.autoSpeak ? 'Turn voice replies off' : 'Turn voice replies on');
  }

  function updateMicButton() {
    const supported = state.voiceInputSupported;
    const icon = elements.mic.querySelector('.material-symbols-outlined');
    let label = 'Speak your prompt';

    elements.mic.disabled = !supported;
    elements.mic.classList.toggle('is-processing', state.isProcessingVoice);
    elements.mic.classList.toggle('is-listening', state.isListening);
    elements.field.classList.toggle('is-listening', state.isListening || state.isProcessingVoice);
    elements.mic.setAttribute('aria-pressed', state.isListening ? 'true' : 'false');

    if (!supported) {
      label = 'Voice input unavailable';
      icon.textContent = 'mic_off';
    } else if (state.isListening) {
      label = 'Stop voice recording';
      icon.textContent = 'graphic_eq';
    } else if (state.isProcessingVoice) {
      label = 'Finishing voice input';
      icon.textContent = 'hourglass_top';
    } else {
      icon.textContent = 'mic';
    }

    elements.mic.setAttribute('aria-label', label);
    elements.mic.title = label;

    if (!supported) {
      setHint(getVoiceUnavailableHint(), 'error');
    }
  }

  function scoreVoice(voice) {
    if (!voice) {
      return -1;
    }

    const name = String(voice.name || '').toLowerCase();
    const lang = String(voice.lang || '').toLowerCase();
    let score = 0;

    if (lang.indexOf('en-in') === 0) {
      score += 80;
    } else if (lang.indexOf('en-gb') === 0) {
      score += 72;
    } else if (lang.indexOf('en-us') === 0) {
      score += 68;
    } else if (lang.indexOf('en-') === 0) {
      score += 60;
    }

    if (voice.default) {
      score += 10;
    }

    if (name.indexOf('google') !== -1) {
      score += 16;
    }
    if (name.indexOf('microsoft') !== -1) {
      score += 14;
    }
    if (name.indexOf('natural') !== -1) {
      score += 18;
    }
    if (name.indexOf('neural') !== -1) {
      score += 18;
    }
    if (name.indexOf('aria') !== -1 || name.indexOf('jenny') !== -1 || name.indexOf('guy') !== -1 || name.indexOf('sara') !== -1 || name.indexOf('heera') !== -1 || name.indexOf('prabhat') !== -1) {
      score += 10;
    }
    if (name.indexOf('zira') !== -1 || name.indexOf('mark') !== -1) {
      score -= 8;
    }

    return score;
  }

  function selectPreferredVoice() {
    if (!('speechSynthesis' in window)) {
      state.preferredVoice = null;
      return;
    }

    const voices = window.speechSynthesis.getVoices();
    if (!voices || !voices.length) {
      state.preferredVoice = null;
      return;
    }

    state.preferredVoice = voices.slice().sort(function (a, b) {
      return scoreVoice(b) - scoreVoice(a);
    })[0] || null;
  }

  function speak(html) {
    if (!state.autoSpeak || !('speechSynthesis' in window)) {
      return;
    }

    const text = normalizeSpeechText(plainTextFromHtml(html));
    if (!text) {
      return;
    }

    window.speechSynthesis.cancel();
    const utterance = new SpeechSynthesisUtterance(text);
    if (state.preferredVoice) {
      utterance.voice = state.preferredVoice;
      utterance.lang = state.preferredVoice.lang || 'en-IN';
    } else {
      utterance.lang = 'en-IN';
    }
    utterance.rate = 0.88;
    utterance.pitch = 1.02;
    utterance.volume = 1;
    window.speechSynthesis.speak(utterance);
  }

  function renderQuickActions() {
    elements.quickActions.innerHTML = '';
    quickActions.forEach(function (action) {
      const button = document.createElement('button');
      button.type = 'button';
      button.textContent = action.label;
      button.addEventListener('click', function () {
        handleUserMessage(action.prompt, true);
      });
      elements.quickActions.appendChild(button);
    });
  }

  function appendMessageActions(wrapper, actions) {
    if (!Array.isArray(actions) || !actions.length) {
      return;
    }

    const actionsWrap = document.createElement('div');
    actionsWrap.className = 'cyi-chatbot__message-actions';

    actions.forEach(function (action) {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'cyi-chatbot__action';
      button.textContent = action.label;
      button.addEventListener('click', function () {
        if (action.type === 'reset') {
          resetChat();
          return;
        }
        if (action.type === 'link' && action.href) {
          window.location.href = action.href;
          return;
        }
        if (action.type === 'lead') {
          startLeadFlow(action.topic || 'general', action.subject || null);
          return;
        }
        if (action.type === 'prompt' && action.prompt) {
          handleUserMessage(action.prompt, true);
        }
      });
      actionsWrap.appendChild(button);
    });

    wrapper.appendChild(actionsWrap);
  }

  function getTextNodes(node, collector) {
    if (!node) {
      return;
    }

    if (node.nodeType === Node.TEXT_NODE) {
      collector.push(node);
      return;
    }

    Array.prototype.forEach.call(node.childNodes || [], function (child) {
      getTextNodes(child, collector);
    });
  }

  function typeHtmlIntoBubble(bubble, html) {
    return new Promise(function (resolve) {
      const template = document.createElement('template');
      template.innerHTML = html;

      const fragment = template.content.cloneNode(true);
      const textNodes = [];
      getTextNodes(fragment, textNodes);

      if (!textNodes.length) {
        bubble.innerHTML = html;
        scrollToBottom();
        resolve();
        return;
      }

      const textContents = textNodes.map(function (node) {
        return node.textContent || '';
      });

      textNodes.forEach(function (node) {
        node.textContent = '';
      });

      bubble.innerHTML = '';
      bubble.appendChild(fragment);
      bubble.classList.add('is-streaming');
      scrollToBottom();

      const characters = [];
      textNodes.forEach(function (node, index) {
        Array.prototype.forEach.call(textContents[index], function (character) {
          characters.push({ node: node, character: character });
        });
      });

      let pointer = 0;

      function step() {
        const remaining = characters.length - pointer;
        if (remaining <= 0) {
          bubble.classList.remove('is-streaming');
          resolve();
          return;
        }

        const batchSize = remaining > 140 ? 4 : remaining > 60 ? 3 : 2;
        const limit = Math.min(pointer + batchSize, characters.length);

        while (pointer < limit) {
          const item = characters[pointer];
          item.node.textContent += item.character;
          pointer += 1;
        }

        scrollToBottom();
        window.setTimeout(step, 16);
      }

      step();
    });
  }

  function addMessage(role, html, actions, options) {
    const wrapper = document.createElement('article');
    wrapper.className = 'cyi-chatbot__message cyi-chatbot__message--' + role;

    const bubble = document.createElement('div');
    bubble.className = 'cyi-chatbot__bubble';
    wrapper.appendChild(bubble);

    elements.messages.appendChild(wrapper);
    scrollToBottom();

    const shouldAnimate = role === 'bot' && (!options || options.animate !== false);
    const shouldSpeak = role === 'bot' && (!options || options.speak !== false);

    if (shouldAnimate) {
      typeHtmlIntoBubble(bubble, html).then(function () {
        appendMessageActions(wrapper, actions);
        scrollToBottom();
        if (shouldSpeak) {
          speak(html);
        }
        if (options && typeof options.onComplete === 'function') {
          options.onComplete(wrapper);
        }
      });
      return wrapper;
    }

    bubble.innerHTML = html;
    appendMessageActions(wrapper, actions);

    if (shouldSpeak) {
      speak(html);
    }

    if (options && typeof options.onComplete === 'function') {
      options.onComplete(wrapper);
    }

    return wrapper;
  }

  function addTyping() {
    const wrapper = document.createElement('article');
    wrapper.className = 'cyi-chatbot__message cyi-chatbot__message--bot';
    wrapper.dataset.typing = 'true';
    wrapper.innerHTML = '<div class="cyi-chatbot__bubble"><div class="cyi-chatbot__thinking"><span class="cyi-chatbot__thinking-label">AI is thinking</span><span class="cyi-chatbot__typing" aria-hidden="true"><span></span><span></span><span></span></span></div></div>';
    elements.messages.appendChild(wrapper);
    scrollToBottom();
    return wrapper;
  }

  function removeTyping(node) {
    if (node && node.parentNode) {
      node.parentNode.removeChild(node);
    }
  }

  function containsAny(input, terms) {
    return terms.some(function (term) {
      return input.indexOf(term) !== -1;
    });
  }

  function matchesPattern(input, pattern) {
    return pattern.test(String(input || ''));
  }

  function summarizeCourses(list) {
    if (!list || !list.length) {
      return 'The training program catalog is the best place to see the current options.';
    }
    return list.slice(0, 3).map(function (item) {
      return item.title;
    }).join(', ');
  }

  function getLeadInterestPrompt(flow) {
    if (!flow) {
      return 'Tell me what you are interested in.';
    }

    if (flow.topic === 'course') {
      return 'Which training program are you interested in? You can type the program name or say general guidance.';
    }

    if (flow.topic === 'workshop') {
      return 'Which workshop or workshop topic are you interested in?';
    }

    if (flow.topic === 'placement' || flow.topic === 'career') {
      return 'Which role, path, or career area do you want help with?';
    }

    return 'Tell me which area you want help with.';
  }

  function getLeadMessagePrompt(flow) {
    if (!flow) {
      return 'Now tell me what you need help with.';
    }

    if (flow.topic === 'course') {
      return 'Now tell me what you want to know about this training program, like fees, admission, timing, or roadmap.';
    }

    if (flow.topic === 'workshop') {
      return 'Now tell me what you need for the workshop, like registration, timing, venue, or joining details.';
    }

    if (flow.topic === 'mentorship') {
      return 'Now tell me what kind of mentorship help you need.';
    }

    if (flow.topic === 'placement' || flow.topic === 'career') {
      return 'Now tell me what kind of career or placement help you need.';
    }

    return 'Now tell me what you need help with.';
  }

  function getNextLeadStep(flow) {
    if (!flow.values.name) {
      return 'name';
    }
    if (!flow.values.email) {
      return 'email';
    }
    if (!Object.prototype.hasOwnProperty.call(flow.values, 'phone')) {
      return 'phone';
    }
    if ((flow.topic === 'course' || flow.topic === 'workshop' || flow.topic === 'placement' || flow.topic === 'career') && !flow.values.courseInterest) {
      return 'interest';
    }
    if (!flow.values.message) {
      return 'message';
    }
    return null;
  }

  function extractLeadDetails(message, context, matchedCourses) {
    const raw = String(message || '').trim();
    const details = {};

    const emailMatch = raw.match(/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i);
    if (emailMatch) {
      details.email = emailMatch[0];
    }

    const phoneMatch = raw.match(/(?:\+?\d[\d\s\-()]{7,}\d)/);
    if (phoneMatch) {
      details.phone = phoneMatch[0].trim();
    }

    const nameMatch = raw.match(/\b(?:my name is|i am|i'm|this is)\s+([a-z][a-z\s'.-]{1,60})/i);
    if (nameMatch) {
      details.name = nameMatch[1]
        .replace(/\b(and|for|about|regarding|want|need|looking)\b.*$/i, '')
        .trim();
    }

    const matchedCourse = Array.isArray(matchedCourses) && matchedCourses.length ? matchedCourses[0] : null;
    if (matchedCourse) {
      details.courseId = matchedCourse.id || null;
      details.courseInterest = matchedCourse.title || null;
    }

    if (!details.courseInterest && context && Array.isArray(context.workshops)) {
      const workshopMatch = context.workshops.find(function (item) {
        return item && item.title && raw.toLowerCase().indexOf(String(item.title).toLowerCase()) !== -1;
      });
      if (workshopMatch) {
        details.courseInterest = workshopMatch.title;
      }
    }

    const cleanedMessage = raw
      .replace(/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/ig, ' ')
      .replace(/(?:\+?\d[\d\s\-()]{7,}\d)/g, ' ')
      .replace(/\b(?:my name is|i am|i'm|this is)\s+[a-z][a-z\s'.-]{1,60}/i, ' ')
      .replace(/\s+/g, ' ')
      .trim();

    if (cleanedMessage.length >= 12) {
      details.message = cleanedMessage;
    }

    return details;
  }

  function inferLeadTopic(input, matchedCourses) {
    if (Array.isArray(matchedCourses) && matchedCourses.length) {
      return 'course';
    }
    if (containsAny(input, ['workshop', 'bootcamp'])) {
      return 'workshop';
    }
    if (containsAny(input, ['mentorship', 'mentor', 'roadmap'])) {
      return 'mentorship';
    }
    if (containsAny(input, ['placement'])) {
      return 'placement';
    }
    if (containsAny(input, ['career', 'job'])) {
      return 'career';
    }
    if (containsAny(input, ['training program', 'training programs', 'course', 'courses', 'admission', 'fees', 'price'])) {
      return 'course';
    }
    return 'support';
  }

  function buildLeadSubject(topic, details) {
    const interest = details && details.courseInterest ? ' - ' + details.courseInterest : '';
    if (topic === 'course') {
      return 'Training program inquiry' + interest;
    }
    if (topic === 'workshop') {
      return 'Workshop inquiry' + interest;
    }
    if (topic === 'mentorship') {
      return 'Mentorship request';
    }
    if (topic === 'placement') {
      return 'Placement support request' + interest;
    }
    if (topic === 'career') {
      return 'Career inquiry' + interest;
    }
    return 'Support request';
  }

  function startLeadFlow(topic, subject, seedValues) {
    state.leadFlow = {
      topic: topic || 'general',
      subject: subject || null,
      values: Object.assign({}, seedValues || {}),
    };

    state.leadFlow.step = getNextLeadStep(state.leadFlow);

    if (!state.leadFlow.step) {
      submitLeadFlow(state.leadFlow);
      return;
    }

    if (state.leadFlow.step === 'name') {
      addMessage('bot', '<p>I can raise this inquiry for you.</p><p>Start with your full name.</p>');
      return;
    }

    if (state.leadFlow.step === 'email') {
      addMessage('bot', '<p>I can raise this inquiry for you.</p><p>Please share your email address.</p>');
      return;
    }

    if (state.leadFlow.step === 'phone') {
      addMessage('bot', '<p>I already have some of the details.</p><p>Add your phone number, or type skip.</p>');
      return;
    }

    if (state.leadFlow.step === 'interest') {
      addMessage('bot', '<p>I already have some of the details.</p><p>' + escapeHtml(getLeadInterestPrompt(state.leadFlow)) + '</p>');
      return;
    }

    addMessage('bot', '<p>I already have some of the details.</p><p>' + escapeHtml(getLeadMessagePrompt(state.leadFlow)) + '</p>');
  }

  function cancelLeadFlow() {
    state.leadFlow = null;
    addMessage('bot', '<p>No problem. The request flow is cancelled.</p>');
  }

  function resetChat() {
    state.leadFlow = null;
    elements.messages.innerHTML = '';
    if (state.isListening || state.isProcessingVoice) {
      cancelRecognition(false);
    } else {
      resetRecognitionDraft(false);
      updateMicButton();
    }
    state.isListening = false;
    setComposerValue('');
    setHint(getDefaultHint());
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
    }
    welcome();
  }

  function handleLeadFlowInput(rawMessage) {
    const flow = state.leadFlow;
    const message = rawMessage.trim();
    const lower = message.toLowerCase();

    if (!flow) {
      return false;
    }

    if (lower === 'cancel') {
      cancelLeadFlow();
      return true;
    }

    if (flow.step === 'name') {
      if (message.length < 3) {
        addMessage('bot', '<p>Please send your full name.</p>');
        return true;
      }
      flow.values.name = message;
      flow.step = getNextLeadStep(flow);
      if (flow.step === 'email') {
        addMessage('bot', '<p>Great. Now your email address.</p>');
        return true;
      }
      if (flow.step === 'phone') {
        addMessage('bot', '<p>Great. Add your phone number, or type skip.</p>');
        return true;
      }
      if (flow.step === 'interest') {
        addMessage('bot', '<p>' + escapeHtml(getLeadInterestPrompt(flow)) + '</p>');
        return true;
      }
      if (flow.step === 'message') {
        addMessage('bot', '<p>' + escapeHtml(getLeadMessagePrompt(flow)) + '</p>');
        return true;
      }
      submitLeadFlow(flow);
      return true;
    }

    if (flow.step === 'email') {
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(message)) {
        addMessage('bot', '<p>Please enter a valid email.</p>');
        return true;
      }
      flow.values.email = message;
      flow.step = getNextLeadStep(flow);
      if (flow.step === 'phone') {
        addMessage('bot', '<p>Add your phone number, or type skip.</p>');
        return true;
      }
      if (flow.step === 'interest') {
        addMessage('bot', '<p>' + escapeHtml(getLeadInterestPrompt(flow)) + '</p>');
        return true;
      }
      if (flow.step === 'message') {
        addMessage('bot', '<p>' + escapeHtml(getLeadMessagePrompt(flow)) + '</p>');
        return true;
      }
      submitLeadFlow(flow);
      return true;
    }

    if (flow.step === 'phone') {
      if (lower !== 'skip' && !/^[+]?[0-9\s\-()]{7,20}$/.test(message)) {
        addMessage('bot', '<p>Please enter a valid phone number, or type skip.</p>');
        return true;
      }
      flow.values.phone = lower === 'skip' ? '' : message;
      flow.step = getNextLeadStep(flow);
      if (flow.step === 'interest') {
        addMessage('bot', '<p>' + escapeHtml(getLeadInterestPrompt(flow)) + '</p>');
        return true;
      }
      addMessage('bot', '<p>' + escapeHtml(getLeadMessagePrompt(flow)) + '</p>');
      return true;
    }

    if (flow.step === 'interest') {
      if (message.length < 2) {
        addMessage('bot', '<p>Please share a little more detail about what you are interested in.</p>');
        return true;
      }
      flow.values.courseInterest = message;
      flow.step = getNextLeadStep(flow);
      addMessage('bot', '<p>' + escapeHtml(getLeadMessagePrompt(flow)) + '</p>');
      return true;
    }

    if (flow.step === 'message') {
      if (message.length < 6) {
        addMessage('bot', '<p>Please add a little more detail.</p>');
        return true;
      }
      flow.values.message = message;
      submitLeadFlow(flow);
      return true;
    }

    return false;
  }

  function submitLeadFlow(flow) {
    const typingNode = addTyping();

    fetch(config.inquiryUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': config.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        name: flow.values.name,
        email: flow.values.email,
        phone: flow.values.phone || null,
        message: flow.values.message,
        topic: flow.topic,
        subject: flow.subject,
        intent: flow.topic,
        course_id: flow.values.courseId || null,
        course_interest: flow.values.courseInterest || null,
        page_url: window.location.pathname + window.location.search,
      })
    })
      .then(function (response) {
        return response.json().catch(function () {
          return {};
        }).then(function (payload) {
          if (!response.ok) {
            throw new Error(payload.message || payload.error || 'I could not send that right now.');
          }
          return payload;
        });
      })
      .then(function (payload) {
        state.leadFlow = null;
        removeTyping(typingNode);
        addMessage('bot', '<p>' + escapeHtml(payload.message || 'Your message has been sent.') + '</p><p>The team now has your inquiry details and can follow up from the LMS inquiry panel.</p>');
      })
      .catch(function (error) {
        removeTyping(typingNode);
        addMessage('bot', '<p>' + escapeHtml(error.message || 'I could not send that right now.') + '</p>');
      });
  }

  function detectNavigationRequest(input) {
    return matchesPattern(input, /\b(go to|take me to|open|redirect me to|navigate to|show me|bring me to|take me into|can you take me there|send me to)\b/);
  }

  function getNavigationTarget(input, context, matchedCourses) {
    if (Array.isArray(matchedCourses) && matchedCourses.length && matchedCourses[0].url) {
      return {
        label: matchedCourses[0].title,
        href: matchedCourses[0].url
      };
    }

    const targets = [
      { label: 'Workshop Page', href: context.routes.workshop, terms: ['workshop', 'bootcamp'] },
      { label: 'Mentorship Page', href: context.routes.mentorship, terms: ['mentorship', 'mentor'] },
      { label: 'Training Programs Page', href: context.routes.courses, terms: ['training program', 'training programs', 'course', 'courses', 'admission'] },
      { label: 'Placement Page', href: context.routes.placement, terms: ['placement', 'career support'] },
      { label: 'Contact Page', href: context.routes.contact, terms: ['contact', 'support', 'team', 'human'] },
      { label: 'Career Paths Page', href: context.routes.career_paths, terms: ['career path', 'career paths'] },
      { label: 'Careers Page', href: context.routes.careers, terms: ['career', 'job opening', 'jobs'] },
      { label: 'Corporate Training Page', href: context.routes.corporate_training, terms: ['corporate training', 'company training'] },
      { label: 'Login Page', href: context.routes.login, terms: ['login', 'sign in'] },
      { label: 'Register Page', href: context.routes.register, terms: ['register', 'signup', 'sign up'] },
    ];

    return targets.find(function (target) {
      return target.href && containsAny(input, target.terms);
    }) || null;
  }

  function buildResponse(rawMessage) {
    const input = rawMessage.toLowerCase();
    const context = state.context || { routes: {}, brand: {}, online_courses: [], offline_courses: [], workshops: [], jobs: [], quick_answers: {} };
    const greeting = getTimeGreeting();
    const matchedCourses = findMatchingCourses(input, context);
    const collections = getCourseCollections(context);
    const hasGreeting = matchesPattern(input, /\b(hello|hi|hey|namaste)\b/);
    const hasThanks = matchesPattern(input, /\b(thank you|thanks|thanku|thx|tysm)\b/);
    const hasGoodbye = matchesPattern(input, /\b(bye|goodbye|see you|take care|ok bye|okay bye)\b/);
    const hasTopicIntent = containsAny(input, ['training program', 'training programs', 'course', 'courses', 'admission', 'fees', 'price', 'mentorship', 'mentor', 'roadmap', 'workshop', 'bootcamp', 'placement', 'job', 'career support', 'contact', 'support', 'human', 'call', 'offline', 'classroom', 'certificate', 'certification', 'login', 'register', 'signup', 'sign in']);
    const navigationTarget = detectNavigationRequest(input) ? getNavigationTarget(input, context, matchedCourses) : null;
    const wantsInquiry = matchesPattern(input, /\b(contact me|call me|reach me|get in touch|raise (an )?inquir|book (a )?(call|demo)|i need help|i need support|i want support|i want admission|admission help|connect me|team contact)\b/);

    if (navigationTarget) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'Sure. I can take you to the <strong>' + escapeHtml(navigationTarget.label) + '</strong>.</p><p>Redirecting you now.</p>',
        actions: [
          { label: 'Open Now', type: 'link', href: navigationTarget.href }
        ],
        navigateTo: navigationTarget.href
      };
    }

    if (wantsInquiry) {
      const leadTopic = inferLeadTopic(input, matchedCourses);
      const leadDetails = extractLeadDetails(rawMessage, context, matchedCourses);
      return {
        startLeadFlow: true,
        leadFlow: {
          topic: leadTopic,
          subject: buildLeadSubject(leadTopic, leadDetails),
          seedValues: leadDetails
        }
      };
    }

    if (matchedCourses.length) {
      const matchedCourse = matchedCourses[0];
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'I found a related training program for you.</p><p><strong>' + escapeHtml(matchedCourse.title) + '</strong></p><p>' + escapeHtml(buildCourseSummary(matchedCourse) || 'You can open the training program page for full details.') + '.</p>',
        actions: buildCourseButtons(matchedCourses, 'All Training Programs', context.routes.courses)
      };
    }

    if (hasGreeting && !hasTopicIntent) {
      return {
        html: '<p>' + greeting + '. How can I help you today?</p>',
        actions: [
          { label: 'Training Program', type: 'prompt', prompt: 'training program' },
          { label: 'Mentorship', type: 'prompt', prompt: 'mentorship' },
          { label: 'Workshop', type: 'prompt', prompt: 'workshops' }
        ]
      };
    }

    if (hasThanks && !hasTopicIntent) {
      return {
        html: '<p>You are very welcome.</p><p>I am always here for you if you need help with training programs, mentorship, workshops, support, or anything else in this LMS.</p>'
      };
    }

    if (hasGoodbye && !hasTopicIntent) {
      return {
        html: '<p>Take care.</p><p>You are always welcome here, and I will be here for you whenever you need help again.</p>'
      };
    }

    if (containsAny(input, ['certificate', 'certification'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'Yes. Eligible learners can access certificates after completing their training program requirements.</p><p>' + escapeHtml(context.quick_answers.certificates || '') + '</p>',
        actions: [
          context.routes.login ? { label: 'Student Login', type: 'link', href: context.routes.login } : null
        ].filter(Boolean)
      };
    }

    if (containsAny(input, ['mentorship', 'mentor', 'roadmap'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'Mentorship is available for guidance, planning, and next-step support.</p><p>If you want, I can send a mentorship request to the team.</p>',
        actions: [
          context.routes.mentorship ? { label: 'Open Mentorship', type: 'link', href: context.routes.mentorship } : null,
          { label: 'Request Mentorship', type: 'lead', topic: 'mentorship', subject: 'Mentorship request' }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, ['workshop', 'bootcamp'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'The workshop section is live in this LMS.</p><p>Current workshop focus includes: ' + escapeHtml(summarizeCourses(context.workshops)) + '.</p><p>You can open the workshop page for dates, venue, and registration details.</p>',
        actions: [
          context.routes.workshop ? { label: 'Open Workshop Page', type: 'link', href: context.routes.workshop } : null,
          { label: 'Workshop Inquiry', type: 'lead', topic: 'workshop', subject: 'Workshop inquiry' }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, ['placement', 'job', 'career support'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'This LMS includes placement-focused guidance and a public placement page.</p><p>' + escapeHtml(context.quick_answers.placement || 'If you want help with that path, I can connect you to the team.') + '</p>',
        actions: [
          context.routes.placement ? { label: 'Placement Page', type: 'link', href: context.routes.placement } : null,
          { label: 'Placement Help', type: 'lead', topic: 'placement', subject: 'Placement support request' }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, ['contact', 'support', 'human', 'call'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'You can contact the team directly at <strong>' + escapeHtml(context.brand.email || 'codeinyourself@gmail.com') + '</strong> or <strong>' + escapeHtml(context.brand.phone || '+91 90164 27165') + '</strong>.</p>',
        actions: [
          context.routes.contact ? { label: 'Contact Page', type: 'link', href: context.routes.contact } : null,
          { label: 'Send Message', type: 'lead', topic: 'support', subject: 'Support request' }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, ['offline', 'classroom'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'Offline options are available through the training program catalog.</p><p>Some current offline choices include ' + escapeHtml(summarizeCourses(collections.offline)) + '.</p>',
        actions: buildCourseButtons(collections.offline, 'Offline Training Programs', context.routes.courses ? context.routes.courses + '?mode=offline' : null)
      };
    }

    if (containsAny(input, ['training program', 'training programs', 'course', 'courses', 'admission', 'fees', 'price'])) {
      const featuredCourses = getAllCourses(context).slice(0, 3);
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'You can explore training programs from the catalog.</p><p>Some current options include ' + escapeHtml(summarizeCourses(getAllCourses(context))) + '.</p><p>If you want a specific training program, type its name and I will take you to that program page.</p>',
        actions: buildCourseButtons(featuredCourses, 'Browse Training Programs', context.routes.courses).concat([
          { label: 'Training Program Guidance', type: 'lead', topic: 'course', subject: 'Training program guidance request' }
        ])
      };
    }

    if (containsAny(input, ['login', 'register', 'signup', 'sign in'])) {
      return {
        html: '<p>' + (hasGreeting ? greeting + '. ' : '') + 'You can log in if you already have an account, or register as a new learner.</p>',
        actions: [
          context.routes.login ? { label: 'Login', type: 'link', href: context.routes.login } : null,
          context.routes.register ? { label: 'Register', type: 'link', href: context.routes.register } : null
        ].filter(Boolean)
      };
    }

    return {
      html: '<p>' + greeting + '. I am not fully able to answer that exact question yet.</p><p>I can still help with training programs, mentorship, workshops, placement, certificates, login, or support.</p><p>If you want training program details, type the program name and I will show the related page.</p>',
      actions: [
        { label: 'Training Programs', type: 'prompt', prompt: 'training programs' },
        { label: 'Mentorship', type: 'prompt', prompt: 'mentorship' },
        { label: 'Workshop', type: 'prompt', prompt: 'workshops' },
        { label: 'Contact', type: 'prompt', prompt: 'contact team' }
      ]
    };
  }

  function handleUserMessage(rawMessage, fromAction) {
    const message = String(rawMessage || '').trim();
    if (!message) {
      return;
    }

    if (!fromAction) {
      addMessage('user', '<p>' + nl2br(message) + '</p>', null, { speak: false });
    }

    if (handleLeadFlowInput(message)) {
      return;
    }

    const typingNode = addTyping();
    window.setTimeout(function () {
      removeTyping(typingNode);
      const response = buildResponse(message);
      if (response.startLeadFlow && response.leadFlow) {
        startLeadFlow(response.leadFlow.topic, response.leadFlow.subject, response.leadFlow.seedValues || {});
        return;
      }
      addMessage('bot', response.html, response.actions || [], {
        onComplete: function () {
          if (response.navigateTo) {
            window.setTimeout(function () {
              window.location.href = response.navigateTo;
            }, 350);
          }
        }
      });
    }, 650);
  }

  function submitComposer(event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    const value = normalizeComposerText(elements.input.value);
    resetRecognitionDraft(false);
    setComposerValue('');
    handleUserMessage(value, false);
  }

  function autoResizeInput() {
    elements.input.style.height = 'auto';
    elements.input.style.height = Math.min(elements.input.scrollHeight, 112) + 'px';
  }

  function setupRecognition() {
    if (!state.voiceInputSupported) {
      updateMicButton();
      return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = document.documentElement.lang || navigator.language || 'en-IN';
    recognition.continuous = true;
    recognition.interimResults = true;
    recognition.maxAlternatives = 1;

    recognition.onstart = function () {
      state.isListening = true;
      state.isProcessingVoice = false;
      state.ignoreRecognitionEnd = false;
      state.recognitionBaseText = normalizeComposerText(elements.input.value);
      state.recognitionFinalText = '';
      state.recognitionInterimText = '';
      state.hasRecognitionResult = false;
      if ('speechSynthesis' in window) {
        window.speechSynthesis.cancel();
      }
      updateMicButton();
      setHint('Listening now. Speak your prompt and tap the mic again when you are done.', 'active');
    };

    recognition.onend = function () {
      state.isListening = false;

      if (state.ignoreRecognitionEnd) {
        state.ignoreRecognitionEnd = false;
        state.isProcessingVoice = false;
        updateMicButton();
        return;
      }

      const transcript = buildVoicePromptValue();
      const shouldSubmitVoicePrompt = state.hasRecognitionResult && !!normalizeComposerText(transcript);

      state.isProcessingVoice = false;
      updateMicButton();

      if (!shouldSubmitVoicePrompt) {
        setHint(getDefaultHint());
        return;
      }

      setComposerValue(transcript);
      setHint('Voice prompt captured. Sending now...', 'active');
      resetRecognitionDraft(false);
      window.setTimeout(function () {
        submitComposer();
      }, 120);
    };

    recognition.onspeechend = function () {
      if (!state.isListening) {
        return;
      }
      state.isProcessingVoice = true;
      updateMicButton();
      setHint('Processing your voice prompt...', 'active');
    };

    recognition.onerror = function (event) {
      state.isListening = false;
      state.isProcessingVoice = false;
      updateMicButton();

      if (event && event.error === 'aborted' && state.ignoreRecognitionEnd) {
        return;
      }

      if (event && (event.error === 'not-allowed' || event.error === 'service-not-allowed')) {
        setHint('Microphone permission is blocked. Allow mic access in your browser and try again.', 'error');
        return;
      }

      if (event && event.error === 'audio-capture') {
        setHint('No microphone was found. Check your mic connection and try again.', 'error');
        return;
      }

      if (event && event.error === 'no-speech') {
        setHint('I did not hear anything. Tap the mic and speak again.', 'error');
        return;
      }

      if (event && event.error === 'network') {
        setHint('Voice recognition had a network issue. Please try again.', 'error');
        return;
      }

      setHint('Voice input was not captured properly. Please try again.', 'error');
    };

    recognition.onresult = function (event) {
      let finalTranscript = '';
      let interimTranscript = '';

      for (let index = 0; index < event.results.length; index += 1) {
        const result = event.results[index];
        const spokenText = result && result[0] && result[0].transcript ? normalizeComposerText(result[0].transcript) : '';

        if (!spokenText) {
          continue;
        }

        if (result.isFinal) {
          finalTranscript += (finalTranscript ? ' ' : '') + spokenText;
        } else {
          interimTranscript += (interimTranscript ? ' ' : '') + spokenText;
        }
      }

      state.recognitionFinalText = normalizeComposerText(finalTranscript);
      state.recognitionInterimText = normalizeComposerText(interimTranscript);
      state.hasRecognitionResult = !!(state.recognitionFinalText || state.recognitionInterimText);
      setComposerValue(buildVoicePromptValue());
      setHint(state.recognitionInterimText ? 'Listening now. I am updating your prompt live.' : 'Voice prompt almost ready.', 'active');
    };

    state.recognition = recognition;
    updateMicButton();
  }

  function fetchHealth() {
    if (!config.healthUrl) {
      updateHealth('Ready');
      return Promise.resolve();
    }

    return fetch(config.healthUrl, { headers: { Accept: 'application/json' } })
      .then(function (response) {
        if (!response.ok) {
          throw new Error('Offline');
        }
        return response.json();
      })
      .then(function () {
        updateHealth('Connected');
      })
      .catch(function () {
        updateHealth('Local mode');
      });
  }

  function fetchContext() {
    if (!config.contextUrl) {
      return Promise.resolve();
    }

    return fetch(config.contextUrl, { headers: { Accept: 'application/json' } })
      .then(function (response) {
        if (!response.ok) {
          throw new Error('Unable to load context');
        }
        return response.json();
      })
      .then(function (payload) {
        state.context = payload;
      })
      .catch(function () {
        state.context = null;
      });
  }

  function welcome() {
    const greeting = getTimeGreeting();
    addMessage('bot', '<p>' + greeting + '. I am your CYI assistant.</p><p>Ask me about training programs, mentorship, workshops, placement, fees, certificates, or support.</p><p>If you type a training program name, I will try to take you to the related program page.</p>', [
      { label: 'New Chat', type: 'reset' },
      { label: 'Training Programs', type: 'prompt', prompt: 'training programs' },
      { label: 'Mentorship', type: 'prompt', prompt: 'mentorship' },
      { label: 'Workshop', type: 'prompt', prompt: 'workshops' },
      { label: 'Contact', type: 'prompt', prompt: 'contact team' }
    ]);
  }

  elements.launcher.addEventListener('click', function (event) {
    event.preventDefault();
    setOpen(true);
  });

  elements.close.addEventListener('click', function (event) {
    event.preventDefault();
    setOpen(false);
  });

  elements.newChat.addEventListener('click', function (event) {
    event.preventDefault();
    resetChat();
  });

  elements.speakToggle.addEventListener('click', function (event) {
    event.preventDefault();
    if (!state.speechEnabled) {
      return;
    }
    state.autoSpeak = !state.autoSpeak;
    updateSpeakButton();
    if (!state.autoSpeak && 'speechSynthesis' in window) {
      window.speechSynthesis.cancel();
    }
  });

  elements.mic.addEventListener('click', function (event) {
    event.preventDefault();
    event.stopPropagation();

    if (!state.voiceInputSupported || !state.recognition) {
      setHint(getVoiceUnavailableHint(), 'error');
      return;
    }

    if (state.isListening) {
      state.isProcessingVoice = true;
      updateMicButton();
      setHint('Finishing your voice prompt...', 'active');
      try {
        state.recognition.stop();
      } catch (error) {
        setHint('Voice input is busy. Please try again.', 'error');
      }
      return;
    }

    try {
      state.recognition.start();
    } catch (error) {
      setHint('Voice input is busy. Please try again.', 'error');
    }
  });

  elements.form.addEventListener('submit', submitComposer);

  elements.input.addEventListener('input', autoResizeInput);

  elements.input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      submitComposer(event);
    }
  });

  renderQuickActions();
  updateSpeakButton();
  setupRecognition();
  selectPreferredVoice();
  if ('speechSynthesis' in window && typeof window.speechSynthesis.addEventListener === 'function') {
    window.speechSynthesis.addEventListener('voiceschanged', selectPreferredVoice);
  }
  welcome();
  autoResizeInput();

  Promise.all([fetchHealth(), fetchContext()]).then(function () {
    if (state.context && state.context.brand && state.context.brand.name) {
      updateHealth('Connected');
    }
  });
})();
