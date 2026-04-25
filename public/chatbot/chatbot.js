(function () {
  const root = document.getElementById('cyi-chatbot-root');
  if (!root) {
    return;
  }

  const PROFILE_KEY = 'cyi-chatbot-profile-v2';
  const HISTORY_KEY = 'cyi-chatbot-history-v1';
  const LANGUAGE_KEY = 'cyi-chatbot-language-v1';
  const HISTORY_LIMIT = 24;
  const ownerAvatar = String('https://res.cloudinary.com/dqxg5hhfi/image/upload/v1777094905/chatbot2_t3owzh.gif').replace(/"/g, '&quot;');
  const ownerName = String(root.dataset.ownerName || 'CodeInYourself Guide').replace(/"/g, '&quot;');

  const config = {
    contextUrl: root.dataset.contextUrl || '',
    inquiryUrl: root.dataset.inquiryUrl || '',
    csrfToken: root.dataset.csrfToken || '',
  };

  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition || null;
  const isLocalHost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.hostname === '::1';

  const COPY = {
    en: {
      teaserLabel: 'Need guidance? Start here.',
      teaserAria: 'Open chatbot',
      launcherAria: 'Open chatbot',
      panelAria: 'Chatbot panel',
      subtitle: 'Training programs, mentorship, workshops, and support.',
      languageAria: 'Choose chatbot language',
      languageEnglishAria: 'Switch chatbot language to English',
      languageHindiAria: 'Switch chatbot language to Hindi',
      newChatAria: 'Start a new chat',
      speakOnAria: 'Turn voice replies on',
      speakOffAria: 'Turn voice replies off',
      closeAria: 'Close chatbot',
      accessKicker: 'Chatbot Access',
      gateTitle: 'Enter your details',
      gateCopyDefault: 'Save your details once, then chat without filling the form again.',
      gateCopySaved: 'Your details are already saved. You can continue chatting without filling this form again.',
      nameLabel: 'Name',
      namePlaceholder: 'Your full name',
      emailLabel: 'Email',
      emailPlaceholder: 'you@example.com',
      regionLabel: 'Region',
      regionPlaceholder: 'India, UAE, USA...',
      phoneLabel: 'Phone with country code',
      phonePlaceholder: '+91 9876543210',
      formNoteDefault: 'Use your country code, for example +91 9876543210.',
      saveContinue: 'Save and continue',
      readyState: 'Ask your first question below.',
      inputPlaceholderLocked: 'Complete the form to start chatting.',
      inputPlaceholderReady: 'Ask anything...',
      micStartAria: 'Start voice input',
      micStopAria: 'Stop voice input',
      micFinishingAria: 'Finishing voice input',
      micUnavailableAria: 'Voice input unavailable',
      sendAria: 'Send message',
      hintLocked: 'Start the conversation to unlock the chat.',
      hintAsk: 'Ask your question to begin.',
      hintHistoryReady: 'Your previous chat is ready. Continue from here.',
      hintSavingDetails: 'Saving your details...',
      hintListeningStart: 'Listening now. I will send your message when you stop speaking.',
      hintListeningContinue: 'Listening now. Keep speaking.',
      hintVoiceFinishingCaptured: 'Voice captured. Finishing your message...',
      hintVoiceFinishing: 'Finishing your voice message...',
      hintVoiceCapturedEdit: 'Voice message captured. You can continue speaking or edit it.',
      hintVoiceSending: 'Sending your voice message...',
      hintMicPermission: 'Microphone permission is blocked. Allow mic access and try again.',
      hintNoSpeech: 'I could not hear you clearly. Please try again.',
      hintNoMic: 'No microphone was found. Check your microphone and try again.',
      hintVoiceStartError: 'Voice input could not start properly. Please try again.',
      hintVoiceUnavailable: 'Voice input needs HTTPS or a supported browser like Chrome or Edge.',
      hintVoiceBusy: 'Voice input is busy. Please try again.',
      hintSaveDetailsForInquiry: 'Please save your details first so I can send the inquiry.',
      hintSaveDetailsToStart: 'Please save your details first to start the chatbot.',
      typing: 'Thinking...',
      validationName: 'Please enter your full name.',
      validationEmail: 'Please enter a valid email address.',
      validationRegion: 'Please enter your region.',
      validationPhone: 'Please enter your phone number with country code.',
      validationPhoneFormat: 'Please insert the proper number with country code, like +91 9876543210.',
      validationPhoneRegionPrefix: 'For {{region}}, please use a phone number that starts with {{code}}.',
      unableToSaveNow: 'I could not save that right now.',
      saveProfileMessage: 'Visitor completed the chatbot profile form before starting a conversation.',
      saveProfileSubject: 'Chatbot visitor profile',
      profileSavedSuccess: 'Your details are saved. You can start chatting now.',
      profileSaveError: 'I could not save your details right now.',
      inquiryFollowUp: 'Chatbot follow-up request',
      inquirySubjectFallback: 'Chatbot inquiry',
      inquirySuccess: 'Your inquiry has been sent.',
      inquirySuccessTeam: 'The HR team can now see it in the dashboard.',
      inquiryError: 'I could not send that inquiry right now.',
      unableToLoadContext: 'Unable to load context',
      noClearVoiceMessage: 'I did not catch a clear voice message. Please try again.',
      summaryPrice: 'Price',
      summaryLevel: 'Level',
      summaryDuration: 'Duration',
      summaryLanguage: 'Language',
      summaryCampus: 'Campus',
      summarySchedule: 'Schedule',
      summaryAudience: 'For',
      summaryCatalog: 'the current catalog',
      summaryDetailsFallback: 'You can open the training program page for full details.',
      navOpenNow: 'Open Now',
      navRedirectLine: 'Redirecting now.',
      navTakingTo: 'Taking you to the <strong>{{label}}</strong>.',
      labelHomePage: 'Home Page',
      labelTrainingProgramsPage: 'Training Programs Page',
      labelMentorshipPage: 'Mentorship Page',
      labelWorkshopPage: 'Workshop Page',
      labelPlacementPage: 'Placement Page',
      labelContactPage: 'Contact Page',
      labelAboutPage: 'About Page',
      labelCareerPathsPage: 'Career Paths Page',
      labelCareersPage: 'Careers Page',
      labelCorporateTrainingPage: 'Corporate Training Page',
      labelLoginPage: 'Login Page',
      labelRegisterPage: 'Register Page',
      buttonAllTrainingPrograms: 'All Training Programs',
      buttonStudentLogin: 'Student Login',
      buttonTrainingPrograms: 'Training Programs',
      buttonOpenMentorship: 'Open Mentorship',
      buttonRequestMentorship: 'Request Mentorship',
      buttonOpenWorkshopPage: 'Open Workshop Page',
      buttonWorkshopInquiry: 'Workshop Inquiry',
      buttonPlacementPage: 'Placement Page',
      buttonPlacementHelp: 'Placement Help',
      buttonContactPage: 'Contact Page',
      buttonSendMessage: 'Send Message',
      buttonOfflineTrainingPrograms: 'Offline Training Programs',
      buttonBrowseTrainingPrograms: 'Browse Training Programs',
      buttonTrainingGuidance: 'Training Program Guidance',
      buttonLogin: 'Login',
      buttonRegister: 'Register',
      buttonMentorship: 'Mentorship',
      buttonWorkshop: 'Workshop',
      buttonSupport: 'Support',
      buttonSendInquiry: 'Send Inquiry',
      replyInquiryTeam: 'I can send this request to the team for you.',
      replyCertificate1: 'Eligible learners can access certificates after completing their training program requirements.',
      replyMentorship1: 'Mentorship is available for guidance, planning, and next-step support.',
      replyMentorship2: 'If you want, I can send a mentorship request to the team.',
      replyWorkshop1: 'The workshop section is live.',
      replyWorkshop2: 'Current workshop focus includes {{items}}.',
      replyPlacement1: 'This LMS includes placement-focused guidance and career support.',
      replyPlacement2: '{{text}}',
      replyContact1: 'You can contact the team directly at <strong>{{email}}</strong> or <strong>{{phone}}</strong>.',
      replyOffline1: 'Offline options are available through the training program catalog.',
      replyOffline2: 'Some current offline choices include {{items}}.',
      replyPrograms1: 'You can explore training programs from the catalog.',
      replyPrograms2: 'Some current options include {{items}}.',
      replyLoginRegister: 'You can log in if you already have an account, or register as a new learner.',
      replyGreeting: 'Hello. Ask me about training programs, mentorship, workshops, placements, or support.',
      replyFallback1: 'I can help with training programs, mentorship, workshops, placements, certificates, login, and support.',
      replyFallback2: 'Ask a more specific question and I will guide you.',
      replyMatchedCourse1: '<strong>{{title}}</strong>',
      replyMatchedCourse2: '{{summary}}.',
      quickAnswerPlacementFallback: 'If you want help with that path, I can connect you to the team.',
      subjectCourse: 'Training program inquiry{{interest}}',
      subjectWorkshop: 'Workshop inquiry{{interest}}',
      subjectMentorship: 'Mentorship request',
      subjectPlacement: 'Placement support request{{interest}}',
      subjectCareer: 'Career inquiry{{interest}}',
      subjectSupport: 'Support request',
    },
    hi: {
      teaserLabel: 'मार्गदर्शन चाहिए? यहां से शुरू करें।',
      teaserAria: 'चैटबॉट खोलें',
      launcherAria: 'चैटबॉट खोलें',
      panelAria: 'चैटबॉट पैनल',
      subtitle: 'ट्रेनिंग प्रोग्राम, मेंटरशिप, वर्कशॉप और सपोर्ट।',
      languageAria: 'चैटबॉट की भाषा चुनें',
      languageEnglishAria: 'चैटबॉट की भाषा अंग्रेज़ी करें',
      languageHindiAria: 'चैटबॉट की भाषा हिंदी करें',
      newChatAria: 'नई चैट शुरू करें',
      speakOnAria: 'आवाज़ में जवाब चालू करें',
      speakOffAria: 'आवाज़ में जवाब बंद करें',
      closeAria: 'चैटबॉट बंद करें',
      accessKicker: 'चैटबॉट एक्सेस',
      gateTitle: 'अपनी जानकारी भरें',
      gateCopyDefault: 'अपनी जानकारी एक बार सेव करें, फिर बिना दोबारा फॉर्म भरे चैट कर सकेंगे।',
      gateCopySaved: 'आपकी जानकारी पहले से सेव है। अब आप बिना दोबारा फॉर्म भरे चैट जारी रख सकते हैं।',
      nameLabel: 'नाम',
      namePlaceholder: 'आपका पूरा नाम',
      emailLabel: 'ईमेल',
      emailPlaceholder: 'you@example.com',
      regionLabel: 'क्षेत्र',
      regionPlaceholder: 'भारत, UAE, USA...',
      phoneLabel: 'कंट्री कोड के साथ फोन नंबर',
      phonePlaceholder: '+91 9876543210',
      formNoteDefault: 'कृपया कंट्री कोड के साथ नंबर डालें, जैसे +91 9876543210।',
      saveContinue: 'सेव करके आगे बढ़ें',
      readyState: 'नीचे अपना पहला सवाल पूछें।',
      inputPlaceholderLocked: 'चैट शुरू करने के लिए पहले फॉर्म पूरा करें।',
      inputPlaceholderReady: 'कुछ भी पूछें...',
      micStartAria: 'वॉइस इनपुट शुरू करें',
      micStopAria: 'वॉइस इनपुट रोकें',
      micFinishingAria: 'वॉइस इनपुट पूरा किया जा रहा है',
      micUnavailableAria: 'वॉइस इनपुट उपलब्ध नहीं है',
      sendAria: 'संदेश भेजें',
      hintLocked: 'चैट शुरू करने के लिए बातचीत शुरू करें।',
      hintAsk: 'शुरू करने के लिए अपना सवाल पूछें।',
      hintHistoryReady: 'आपकी पिछली चैट तैयार है। यहीं से आगे बढ़ें।',
      hintSavingDetails: 'आपकी जानकारी सेव की जा रही है...',
      hintListeningStart: 'मैं सुन रहा हूं। आप बोलना बंद करेंगे तो संदेश भेज दिया जाएगा।',
      hintListeningContinue: 'मैं सुन रहा हूं। बोलते रहें।',
      hintVoiceFinishingCaptured: 'आवाज़ कैप्चर हो गई है। आपका संदेश पूरा किया जा रहा है...',
      hintVoiceFinishing: 'आपका वॉइस संदेश पूरा किया जा रहा है...',
      hintVoiceCapturedEdit: 'वॉइस संदेश कैप्चर हो गया है। आप चाहें तो बोलना जारी रखें या इसे एडिट करें।',
      hintVoiceSending: 'आपका वॉइस संदेश भेजा जा रहा है...',
      hintMicPermission: 'माइक्रोफोन की अनुमति बंद है। अनुमति दें और फिर कोशिश करें।',
      hintNoSpeech: 'आपकी आवाज़ साफ़ सुनाई नहीं दी। कृपया फिर से कोशिश करें।',
      hintNoMic: 'कोई माइक्रोफोन नहीं मिला। अपना माइक्रोफोन जांचें और फिर कोशिश करें।',
      hintVoiceStartError: 'वॉइस इनपुट ठीक से शुरू नहीं हो सका। कृपया फिर से कोशिश करें।',
      hintVoiceUnavailable: 'वॉइस इनपुट के लिए HTTPS या Chrome/Edge जैसा समर्थित ब्राउज़र चाहिए।',
      hintVoiceBusy: 'वॉइस इनपुट अभी व्यस्त है। कृपया थोड़ी देर बाद फिर कोशिश करें।',
      hintSaveDetailsForInquiry: 'इन्क्वायरी भेजने से पहले कृपया अपनी जानकारी सेव करें।',
      hintSaveDetailsToStart: 'चैटबॉट शुरू करने से पहले कृपया अपनी जानकारी सेव करें।',
      typing: 'सोच रहा हूं...',
      validationName: 'कृपया अपना पूरा नाम दर्ज करें।',
      validationEmail: 'कृपया सही ईमेल पता दर्ज करें।',
      validationRegion: 'कृपया अपना क्षेत्र दर्ज करें।',
      validationPhone: 'कृपया कंट्री कोड के साथ अपना फोन नंबर दर्ज करें।',
      validationPhoneFormat: 'कृपया सही कंट्री कोड वाला नंबर दर्ज करें, जैसे +91 9876543210।',
      validationPhoneRegionPrefix: '{{region}} के लिए नंबर {{code}} से शुरू होना चाहिए।',
      unableToSaveNow: 'अभी इसे सेव नहीं किया जा सका।',
      saveProfileMessage: 'Visitor completed the chatbot profile form before starting a conversation.',
      saveProfileSubject: 'Chatbot visitor profile',
      profileSavedSuccess: 'आपकी जानकारी सेव हो गई है। अब आप चैट शुरू कर सकते हैं।',
      profileSaveError: 'अभी आपकी जानकारी सेव नहीं हो सकी।',
      inquiryFollowUp: 'Chatbot follow-up request',
      inquirySubjectFallback: 'Chatbot inquiry',
      inquirySuccess: 'आपकी इन्क्वायरी भेज दी गई है।',
      inquirySuccessTeam: 'अब HR टीम इसे डैशबोर्ड में देख सकती है।',
      inquiryError: 'अभी आपकी इन्क्वायरी भेजी नहीं जा सकी।',
      unableToLoadContext: 'कॉन्टेक्स्ट लोड नहीं हो सका',
      noClearVoiceMessage: 'कोई साफ़ वॉइस संदेश नहीं मिला। कृपया फिर से कोशिश करें।',
      summaryPrice: 'फीस',
      summaryLevel: 'स्तर',
      summaryDuration: 'अवधि',
      summaryLanguage: 'भाषा',
      summaryCampus: 'कैंपस',
      summarySchedule: 'शेड्यूल',
      summaryAudience: 'उपयुक्त',
      summaryCatalog: 'मौजूदा कैटलॉग',
      summaryDetailsFallback: 'पूरी जानकारी के लिए आप ट्रेनिंग प्रोग्राम पेज खोल सकते हैं।',
      navOpenNow: 'अभी खोलें',
      navRedirectLine: 'अब आपको वहां ले जाया जा रहा है।',
      navTakingTo: 'आपको <strong>{{label}}</strong> पर ले जाया जा रहा है।',
      labelHomePage: 'होम पेज',
      labelTrainingProgramsPage: 'ट्रेनिंग प्रोग्राम पेज',
      labelMentorshipPage: 'मेंटरशिप पेज',
      labelWorkshopPage: 'वर्कशॉप पेज',
      labelPlacementPage: 'प्लेसमेंट पेज',
      labelContactPage: 'कॉन्टैक्ट पेज',
      labelAboutPage: 'अबाउट पेज',
      labelCareerPathsPage: 'कैरियर पाथ्स पेज',
      labelCareersPage: 'कैरियर्स पेज',
      labelCorporateTrainingPage: 'कॉर्पोरेट ट्रेनिंग पेज',
      labelLoginPage: 'लॉगिन पेज',
      labelRegisterPage: 'रजिस्टर पेज',
      buttonAllTrainingPrograms: 'सभी ट्रेनिंग प्रोग्राम',
      buttonStudentLogin: 'स्टूडेंट लॉगिन',
      buttonTrainingPrograms: 'ट्रेनिंग प्रोग्राम',
      buttonOpenMentorship: 'मेंटरशिप खोलें',
      buttonRequestMentorship: 'मेंटरशिप अनुरोध',
      buttonOpenWorkshopPage: 'वर्कशॉप पेज खोलें',
      buttonWorkshopInquiry: 'वर्कशॉप इन्क्वायरी',
      buttonPlacementPage: 'प्लेसमेंट पेज',
      buttonPlacementHelp: 'प्लेसमेंट सहायता',
      buttonContactPage: 'कॉन्टैक्ट पेज',
      buttonSendMessage: 'संदेश भेजें',
      buttonOfflineTrainingPrograms: 'ऑफलाइन ट्रेनिंग प्रोग्राम',
      buttonBrowseTrainingPrograms: 'ट्रेनिंग प्रोग्राम देखें',
      buttonTrainingGuidance: 'ट्रेनिंग मार्गदर्शन',
      buttonLogin: 'लॉगिन',
      buttonRegister: 'रजिस्टर',
      buttonMentorship: 'मेंटरशिप',
      buttonWorkshop: 'वर्कशॉप',
      buttonSupport: 'सपोर्ट',
      buttonSendInquiry: 'इन्क्वायरी भेजें',
      replyInquiryTeam: 'मैं यह अनुरोध आपकी ओर से टीम तक भेज सकता हूं।',
      replyCertificate1: 'योग्य विद्यार्थी ट्रेनिंग प्रोग्राम की आवश्यकताएं पूरी करने के बाद सर्टिफिकेट प्राप्त कर सकते हैं।',
      replyMentorship1: 'मेंटरशिप मार्गदर्शन, योजना और अगले कदमों के लिए उपलब्ध है।',
      replyMentorship2: 'अगर आप चाहें, तो मैं टीम को मेंटरशिप अनुरोध भेज सकता हूं।',
      replyWorkshop1: 'वर्कशॉप सेक्शन अभी उपलब्ध है।',
      replyWorkshop2: 'अभी वर्कशॉप का फोकस {{items}} पर है।',
      replyPlacement1: 'इस LMS में प्लेसमेंट और करियर सपोर्ट उपलब्ध है।',
      replyPlacement2: '{{text}}',
      replyContact1: 'आप टीम से सीधे <strong>{{email}}</strong> या <strong>{{phone}}</strong> पर संपर्क कर सकते हैं।',
      replyOffline1: 'ऑफलाइन विकल्प ट्रेनिंग प्रोग्राम कैटलॉग में उपलब्ध हैं।',
      replyOffline2: 'कुछ मौजूदा ऑफलाइन विकल्प हैं: {{items}}।',
      replyPrograms1: 'आप कैटलॉग से ट्रेनिंग प्रोग्राम देख सकते हैं।',
      replyPrograms2: 'कुछ मौजूदा विकल्प हैं: {{items}}।',
      replyLoginRegister: 'अगर आपका अकाउंट पहले से है तो लॉगिन करें, नहीं तो नए शिक्षार्थी के रूप में रजिस्टर करें।',
      replyGreeting: 'नमस्ते। आप मुझसे ट्रेनिंग प्रोग्राम, मेंटरशिप, वर्कशॉप, प्लेसमेंट या सपोर्ट के बारे में पूछ सकते हैं।',
      replyFallback1: 'मैं ट्रेनिंग प्रोग्राम, मेंटरशिप, वर्कशॉप, प्लेसमेंट, सर्टिफिकेट, लॉगिन और सपोर्ट में मदद कर सकता हूं।',
      replyFallback2: 'थोड़ा और स्पष्ट सवाल पूछें, मैं आपकी मदद करूंगा।',
      replyMatchedCourse1: '<strong>{{title}}</strong>',
      replyMatchedCourse2: '{{summary}}.',
      quickAnswerPlacementFallback: 'अगर आप चाहें, तो मैं इस रास्ते में मदद के लिए आपको टीम से जोड़ सकता हूं।',
      subjectCourse: 'Training program inquiry{{interest}}',
      subjectWorkshop: 'Workshop inquiry{{interest}}',
      subjectMentorship: 'Mentorship request',
      subjectPlacement: 'Placement support request{{interest}}',
      subjectCareer: 'Career inquiry{{interest}}',
      subjectSupport: 'Support request',
    }
  };

  const INTENTS = {
    training: ['training program', 'training programs', 'course', 'courses', 'admission', 'fees', 'fee', 'price', 'pricing', 'कोर्स', 'कोर्सेस', 'ट्रेनिंग', 'प्रोग्राम', 'एडमिशन', 'फीस', 'प्राइस'],
    mentorship: ['mentorship', 'mentor', 'roadmap', 'मेंटरशिप', 'मेंटोर', 'रोडमैप', 'मार्गदर्शन'],
    workshop: ['workshop', 'bootcamp', 'वर्कशॉप', 'बूटकैंप'],
    placement: ['placement', 'placements', 'job', 'career support', 'career', 'jobs', 'प्लेसमेंट', 'जॉब', 'नौकरी', 'करियर'],
    contact: ['contact', 'support', 'human', 'call', 'team', 'कॉन्टैक्ट', 'संपर्क', 'सपोर्ट', 'टीम', 'कॉल', 'बात'],
    offline: ['offline', 'classroom', 'ऑफलाइन', 'क्लासरूम'],
    certificate: ['certificate', 'certification', 'सर्टिफिकेट', 'प्रमाणपत्र', 'सर्टिफिकेशन'],
    auth: ['login', 'register', 'signup', 'sign in', 'sign up', 'लॉगिन', 'रजिस्टर', 'साइन इन', 'साइन अप'],
    greeting: ['hello', 'hi', 'hey', 'namaste', 'नमस्ते', 'हेलो', 'हाय'],
    inquiry: ['contact me', 'call me', 'reach me', 'get in touch', 'book a call', 'book call', 'book demo', 'i need help', 'i need support', 'i want support', 'i want admission', 'admission help', 'connect me', 'team contact', 'मुझसे संपर्क', 'मुझे कॉल', 'मुझसे बात', 'मदद चाहिए', 'सपोर्ट चाहिए', 'एडमिशन चाहिए', 'टीम से जोड़ो', 'टीम से बात'],
    navigation: ['go to', 'take me to', 'open', 'redirect me to', 'navigate to', 'show me', 'bring me to', 'send me to', 'खोलो', 'ले चलो', 'दिखाओ', 'ओपन', 'भेजो', 'जाना है']
  };

  const regionDialCodes = {
    india: '+91',
    bharat: '+91',
    भारत: '+91',
    usa: '+1',
    us: '+1',
    'united states': '+1',
    canada: '+1',
    uk: '+44',
    'united kingdom': '+44',
    england: '+44',
    uae: '+971',
    dubai: '+971',
    australia: '+61',
    singapore: '+65',
    germany: '+49',
    france: '+33',
  };

  const initialProfile = loadProfile();
  const initialHistory = loadHistory();
  const initialLanguage = loadLanguage();

  const state = {
    context: null,
    profile: initialProfile,
    started: !!initialProfile,
    hasDismissedTeaser: false,
    lastUserMessage: '',
    history: initialHistory,
    language: initialLanguage,
    speechEnabled: 'speechSynthesis' in window,
    autoSpeak: false,
    voiceInputSupported: !!SpeechRecognition && (window.isSecureContext || isLocalHost),
    recognition: null,
    isListening: false,
    isProcessingVoice: false,
    shouldSubmitVoiceOnEnd: false,
    voiceBaseText: '',
    recognitionFinalText: '',
    recognitionInterimText: '',
    recognitionHadResult: false,
    lastRecognitionError: '',
    preferredVoice: null,
  };

  root.innerHTML = `
    <div class="cyi-chatbot" data-chatbot>
      <button class="cyi-chatbot__teaser" type="button" data-teaser>
        <span class="cyi-chatbot__teaser-label" data-teaser-label></span>
      </button>
      <button class="cyi-chatbot__launcher" type="button" data-launcher>
        <span class="cyi-chatbot__launcher-shadow" aria-hidden="true"></span>
        <span class="cyi-chatbot__launcher-icon">
          <img src="${ownerAvatar}" alt="${ownerName}" class="cyi-chatbot__avatar-image" />
        </span>
      </button>
      <section class="cyi-chatbot__panel" data-panel>
        <header class="cyi-chatbot__header">
          <div class="cyi-chatbot__header-main">
            <div class="cyi-chatbot__owner-avatar-shell">
              <img src="${ownerAvatar}" alt="${ownerName}" class="cyi-chatbot__owner-avatar" />
            </div>
            <div class="cyi-chatbot__owner-copy">
              <h2 class="cyi-chatbot__title">${ownerName}</h2>
              <p class="cyi-chatbot__subtitle" data-subtitle></p>
            </div>
          </div>
          <div class="cyi-chatbot__toolbar">
            <button class="cyi-chatbot__icon-button" type="button" data-new-chat><span class="material-symbols-outlined">add_comment</span></button>
            <button class="cyi-chatbot__icon-button" type="button" data-speak-toggle><span class="material-symbols-outlined">volume_off</span></button>
            <button class="cyi-chatbot__icon-button" type="button" data-close><span class="material-symbols-outlined">close</span></button>
          </div>
        </header>
        <div class="cyi-chatbot__body">
          <section class="cyi-chatbot__gate" data-gate>
            <div class="cyi-chatbot__gate-card">
              <p class="cyi-chatbot__gate-kicker" data-gate-kicker></p>
              <h3 class="cyi-chatbot__gate-title" data-gate-title></h3>
              <p class="cyi-chatbot__gate-copy" data-gate-copy></p>
              <form class="cyi-chatbot__profile-form" data-profile-form>
                <label class="cyi-chatbot__form-label" for="cyi-chatbot-name" data-name-label></label>
                <input class="cyi-chatbot__form-input" id="cyi-chatbot-name" name="name" type="text" maxlength="255" autocomplete="name" />
                <label class="cyi-chatbot__form-label" for="cyi-chatbot-email" data-email-label></label>
                <input class="cyi-chatbot__form-input" id="cyi-chatbot-email" name="email" type="email" maxlength="255" autocomplete="email" />
                <label class="cyi-chatbot__form-label" for="cyi-chatbot-region" data-region-label></label>
                <input class="cyi-chatbot__form-input" id="cyi-chatbot-region" name="region" type="text" maxlength="255" autocomplete="address-level1" />
                <label class="cyi-chatbot__form-label" for="cyi-chatbot-phone" data-phone-label></label>
                <input class="cyi-chatbot__form-input" id="cyi-chatbot-phone" name="phone" type="tel" maxlength="30" autocomplete="tel" />
                <p class="cyi-chatbot__form-note" data-form-note></p>
                <button class="cyi-chatbot__primary" type="submit" data-primary></button>
              </form>
            </div>
          </section>
          <div class="cyi-chatbot__ready-state" data-ready-state hidden></div>
          <div class="cyi-chatbot__messages pretty-scroll" data-messages></div>
        </div>
        <footer class="cyi-chatbot__footer">
          <div class="cyi-chatbot__footer-meta">
            <div class="cyi-chatbot__lang-switch" role="group" data-lang-switch>
              <button class="cyi-chatbot__lang-button" type="button" data-lang-toggle="en">EN</button>
              <button class="cyi-chatbot__lang-button" type="button" data-lang-toggle="hi">हिं</button>
            </div>
          </div>
          <form class="cyi-chatbot__composer" data-form>
            <div class="cyi-chatbot__field">
              <textarea class="cyi-chatbot__input" rows="1" data-input disabled></textarea>
              <button class="cyi-chatbot__voice" type="button" disabled data-mic>
                <span class="material-symbols-outlined">mic</span>
              </button>
              <button class="cyi-chatbot__send" type="submit" disabled data-send>
                <span class="material-symbols-outlined">arrow_upward</span>
              </button>
            </div>
          </form>
          <div class="cyi-chatbot__hint" data-hint aria-live="polite"></div>
        </footer>
      </section>
    </div>
  `;

  const elements = {
    shell: root.querySelector('[data-chatbot]'),
    teaser: root.querySelector('[data-teaser]'),
    teaserLabel: root.querySelector('[data-teaser-label]'),
    launcher: root.querySelector('[data-launcher]'),
    panel: root.querySelector('[data-panel]'),
    subtitle: root.querySelector('[data-subtitle]'),
    langSwitch: root.querySelector('[data-lang-switch]'),
    langButtons: root.querySelectorAll('[data-lang-toggle]'),
    close: root.querySelector('[data-close]'),
    newChat: root.querySelector('[data-new-chat]'),
    speakToggle: root.querySelector('[data-speak-toggle]'),
    gate: root.querySelector('[data-gate]'),
    gateKicker: root.querySelector('[data-gate-kicker]'),
    gateTitle: root.querySelector('[data-gate-title]'),
    gateCopy: root.querySelector('[data-gate-copy]'),
    profileForm: root.querySelector('[data-profile-form]'),
    nameLabel: root.querySelector('[data-name-label]'),
    emailLabel: root.querySelector('[data-email-label]'),
    regionLabel: root.querySelector('[data-region-label]'),
    phoneLabel: root.querySelector('[data-phone-label]'),
    primary: root.querySelector('[data-primary]'),
    formNote: root.querySelector('[data-form-note]'),
    messages: root.querySelector('[data-messages]'),
    readyState: root.querySelector('[data-ready-state]'),
    form: root.querySelector('[data-form]'),
    field: root.querySelector('.cyi-chatbot__field'),
    input: root.querySelector('[data-input]'),
    mic: root.querySelector('[data-mic]'),
    send: root.querySelector('[data-send]'),
    hint: root.querySelector('[data-hint]'),
  };

  function loadProfile() {
    try {
      const raw = window.localStorage.getItem(PROFILE_KEY);
      return raw ? JSON.parse(raw) : null;
    } catch (error) {
      return null;
    }
  }

  function saveProfile(profile) {
    state.profile = profile;
    try {
      window.localStorage.setItem(PROFILE_KEY, JSON.stringify(profile));
    } catch (error) {
      // Ignore storage failures and keep the session usable.
    }
  }

  function loadHistory() {
    try {
      const raw = window.localStorage.getItem(HISTORY_KEY);
      const parsed = raw ? JSON.parse(raw) : [];
      return Array.isArray(parsed) ? parsed : [];
    } catch (error) {
      return [];
    }
  }

  function saveHistory() {
    try {
      window.localStorage.setItem(HISTORY_KEY, JSON.stringify(state.history.slice(-HISTORY_LIMIT)));
    } catch (error) {
      // Ignore storage failures and keep the session usable.
    }
  }

  function loadLanguage() {
    try {
      const saved = window.localStorage.getItem(LANGUAGE_KEY);
      return saved === 'hi' ? 'hi' : 'en';
    } catch (error) {
      return 'en';
    }
  }

  function saveLanguage(language) {
    try {
      window.localStorage.setItem(LANGUAGE_KEY, language);
    } catch (error) {
      // Ignore storage failures and keep the session usable.
    }
  }

  function t(key, vars) {
    const pack = COPY[state.language] || COPY.en;
    let text = pack[key];
    if (typeof text !== 'string') {
      text = COPY.en[key] || '';
    }
    if (!vars) {
      return text;
    }
    return Object.keys(vars).reduce(function (result, name) {
      return result.replace(new RegExp('{{' + name + '}}', 'g'), String(vars[name]));
    }, text);
  }

  function rememberMessage(role, html, actions) {
    state.history.push({
      role: role,
      html: html,
      actions: Array.isArray(actions) ? actions : [],
    });
    state.history = state.history.slice(-HISTORY_LIMIT);
    saveHistory();
  }

  function clearHistory() {
    state.history = [];
    try {
      window.localStorage.removeItem(HISTORY_KEY);
    } catch (error) {
      // Ignore storage failures and keep the session usable.
    }
  }

  function normalizeText(value) {
    return String(value || '').replace(/\s+/g, ' ').trim();
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

  function containsAny(input, terms) {
    return terms.some(function (term) {
      return input.indexOf(term) !== -1;
    });
  }

  function matchesPattern(input, pattern) {
    return pattern.test(String(input || ''));
  }

  function getRecognitionLang() {
    return state.language === 'hi' ? 'hi-IN' : 'en-IN';
  }

  function stopActiveListening() {
    if (state.isListening && state.recognition) {
      state.shouldSubmitVoiceOnEnd = false;
      state.isProcessingVoice = false;
      state.lastRecognitionError = 'aborted';
      try {
        state.recognition.stop();
      } catch (error) {
        // Ignore stop timing issues.
      }
    }
  }

  function updateLanguageUI() {
    elements.panel.setAttribute('aria-label', t('panelAria'));
    elements.panel.setAttribute('lang', state.language === 'hi' ? 'hi' : 'en');
    elements.teaser.setAttribute('aria-label', t('teaserAria'));
    elements.launcher.setAttribute('aria-label', t('launcherAria'));
    elements.newChat.setAttribute('aria-label', t('newChatAria'));
    elements.close.setAttribute('aria-label', t('closeAria'));
    elements.teaserLabel.textContent = t('teaserLabel');
    elements.subtitle.textContent = t('subtitle');
    elements.langSwitch.setAttribute('aria-label', t('languageAria'));
    elements.gateKicker.textContent = t('accessKicker');
    elements.gateTitle.textContent = t('gateTitle');
    elements.nameLabel.textContent = t('nameLabel');
    elements.emailLabel.textContent = t('emailLabel');
    elements.regionLabel.textContent = t('regionLabel');
    elements.phoneLabel.textContent = t('phoneLabel');
    elements.primary.textContent = t('saveContinue');
    elements.readyState.textContent = t('readyState');
    elements.profileForm.elements.name.placeholder = t('namePlaceholder');
    elements.profileForm.elements.email.placeholder = t('emailPlaceholder');
    elements.profileForm.elements.region.placeholder = t('regionPlaceholder');
    elements.profileForm.elements.phone.placeholder = t('phonePlaceholder');
    elements.send.setAttribute('aria-label', t('sendAria'));

    Array.prototype.forEach.call(elements.langButtons, function (button) {
      const lang = button.getAttribute('data-lang-toggle');
      const isActive = lang === state.language;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      button.setAttribute('title', lang === 'hi' ? 'Hindi' : 'English');
      button.setAttribute('aria-label', lang === 'hi' ? t('languageHindiAria') : t('languageEnglishAria'));
    });

    syncGate();
    updateSpeakButton();
    updateMicButton();
  }

  function setLanguage(language) {
    const nextLanguage = language === 'hi' ? 'hi' : 'en';
    if (state.language === nextLanguage) {
      return;
    }

    stopActiveListening();
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
    }

    state.language = nextLanguage;
    saveLanguage(nextLanguage);
    selectPreferredVoice();

    if (state.recognition) {
      state.recognition.lang = getRecognitionLang();
    }

    updateLanguageUI();
    openProfileForm();

    if (state.started) {
      setHint(state.history.length ? t('hintHistoryReady') : t('hintAsk'), 'active');
    } else {
      setHint(t('hintLocked'));
    }
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
      bits.push(t('summaryPrice') + ': ' + course.price);
    }
    if (course.level) {
      bits.push(t('summaryLevel') + ': ' + course.level);
    }
    if (course.duration) {
      bits.push(t('summaryDuration') + ': ' + course.duration);
    }
    if (course.language) {
      bits.push(t('summaryLanguage') + ': ' + course.language);
    }
    if (course.campus) {
      bits.push(t('summaryCampus') + ': ' + course.campus);
    }
    if (course.schedule) {
      bits.push(t('summarySchedule') + ': ' + course.schedule);
    }
    if (course.audience) {
      bits.push(t('summaryAudience') + ': ' + course.audience);
    }
    return bits.join(' | ');
  }

  function localizedPrompt(key) {
    if (key === 'training') {
      return state.language === 'hi' ? 'ट्रेनिंग प्रोग्राम' : 'training programs';
    }
    if (key === 'mentorship') {
      return state.language === 'hi' ? 'मेंटरशिप' : 'mentorship';
    }
    if (key === 'workshop') {
      return state.language === 'hi' ? 'वर्कशॉप' : 'workshops';
    }
    return state.language === 'hi' ? 'टीम से संपर्क' : 'contact team';
  }

  function buildCourseButtons(courses, fallbackLabel, fallbackUrl) {
    const actions = [];
    (courses || []).slice(0, 3).forEach(function (course) {
      if (course && course.url) {
        actions.push({
          label: course.title.length > 24 ? course.title.slice(0, 24) + '...' : course.title,
          type: 'link',
          href: course.url,
        });
      }
    });
    if (fallbackUrl) {
      actions.push({ label: fallbackLabel, type: 'link', href: fallbackUrl });
    }
    return actions;
  }

  function detectNavigationRequest(input) {
    return containsAny(input, INTENTS.navigation);
  }

  function getNavigationTarget(input, context, matchedCourses) {
    if (Array.isArray(matchedCourses) && matchedCourses.length && matchedCourses[0].url) {
      return {
        label: matchedCourses[0].title,
        href: matchedCourses[0].url,
      };
    }

    const targets = [
      { label: t('labelHomePage'), href: context.routes.home, terms: ['home', 'homepage', 'main page', 'होम'] },
      { label: t('labelTrainingProgramsPage'), href: context.routes.courses, terms: INTENTS.training.concat(['catalog', 'कैटलॉग']) },
      { label: t('labelMentorshipPage'), href: context.routes.mentorship, terms: INTENTS.mentorship },
      { label: t('labelWorkshopPage'), href: context.routes.workshop, terms: INTENTS.workshop },
      { label: t('labelPlacementPage'), href: context.routes.placement, terms: INTENTS.placement.concat(['career support']) },
      { label: t('labelContactPage'), href: context.routes.contact, terms: INTENTS.contact.concat(['contact page', 'कॉन्टैक्ट पेज']) },
      { label: t('labelAboutPage'), href: context.routes.about, terms: ['about', 'about us', 'अबाउट'] },
      { label: t('labelCareerPathsPage'), href: context.routes.career_paths, terms: ['career path', 'career paths', 'कैरियर पाथ'] },
      { label: t('labelCareersPage'), href: context.routes.careers, terms: ['career', 'careers', 'job opening', 'jobs', 'कैरियर्स', 'जॉब्स'] },
      { label: t('labelCorporateTrainingPage'), href: context.routes.corporate_training, terms: ['corporate training', 'company training', 'कॉर्पोरेट ट्रेनिंग'] },
      { label: t('labelLoginPage'), href: context.routes.login, terms: ['login', 'sign in', 'लॉगिन'] },
      { label: t('labelRegisterPage'), href: context.routes.register, terms: ['register', 'signup', 'sign up', 'रजिस्टर'] },
    ];

    return targets.find(function (target) {
      return target.href && containsAny(input, target.terms);
    }) || null;
  }

  function summarizeCourses(list) {
    if (!list || !list.length) {
      return t('summaryCatalog');
    }
    return list.slice(0, 3).map(function (item) {
      return item.title;
    }).join(', ');
  }

  function inferLeadTopic(input, matchedCourses) {
    if (Array.isArray(matchedCourses) && matchedCourses.length) {
      return 'course';
    }
    if (containsAny(input, INTENTS.workshop)) {
      return 'workshop';
    }
    if (containsAny(input, INTENTS.mentorship)) {
      return 'mentorship';
    }
    if (containsAny(input, INTENTS.placement)) {
      return 'placement';
    }
    if (containsAny(input, ['career', 'job', 'करियर', 'जॉब', 'नौकरी'])) {
      return 'career';
    }
    if (containsAny(input, INTENTS.training)) {
      return 'course';
    }
    return 'support';
  }

  function buildLeadSubject(topic, details) {
    const interest = details && details.courseInterest ? ' - ' + details.courseInterest : '';
    if (topic === 'course') {
      return t('subjectCourse', { interest: interest });
    }
    if (topic === 'workshop') {
      return t('subjectWorkshop', { interest: interest });
    }
    if (topic === 'mentorship') {
      return t('subjectMentorship');
    }
    if (topic === 'placement') {
      return t('subjectPlacement', { interest: interest });
    }
    if (topic === 'career') {
      return t('subjectCareer', { interest: interest });
    }
    return t('subjectSupport');
  }

  function extractLeadDetails(message, context, matchedCourses) {
    const details = {};
    const matchedCourse = Array.isArray(matchedCourses) && matchedCourses.length ? matchedCourses[0] : null;

    if (matchedCourse) {
      details.courseId = matchedCourse.id || null;
      details.courseInterest = matchedCourse.title || null;
    }

    if (!details.courseInterest && context && Array.isArray(context.workshops)) {
      const workshopMatch = context.workshops.find(function (item) {
        return item && item.title && String(message || '').toLowerCase().indexOf(String(item.title).toLowerCase()) !== -1;
      });
      if (workshopMatch) {
        details.courseInterest = workshopMatch.title;
      }
    }

    return details;
  }

  function getExpectedCountryCode(region) {
    const normalized = normalizeText(region).toLowerCase();
    if (!normalized) {
      return '';
    }

    if (regionDialCodes[normalized]) {
      return regionDialCodes[normalized];
    }

    const matchedKey = Object.keys(regionDialCodes).find(function (key) {
      return normalized.indexOf(key) !== -1;
    });

    return matchedKey ? regionDialCodes[matchedKey] : '';
  }

  function normalizePhone(value) {
    return String(value || '').replace(/[^\d+]/g, '');
  }

  function validateProfile(values) {
    const name = normalizeText(values.name);
    const email = normalizeText(values.email);
    const region = normalizeText(values.region);
    const phone = normalizePhone(values.phone);
    const expectedCode = getExpectedCountryCode(region);

    if (name.length < 3) {
      return { ok: false, message: t('validationName') };
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      return { ok: false, message: t('validationEmail') };
    }

    if (!region) {
      return { ok: false, message: t('validationRegion') };
    }

    if (!phone) {
      return { ok: false, message: t('validationPhone') };
    }

    if (!/^\+[1-9]\d{6,14}$/.test(phone)) {
      return { ok: false, message: t('validationPhoneFormat') };
    }

    if (expectedCode && phone.indexOf(expectedCode) !== 0) {
      return {
        ok: false,
        message: t('validationPhoneRegionPrefix', {
          region: region,
          code: expectedCode,
        }),
      };
    }

    return {
      ok: true,
      values: {
        name: name,
        email: email,
        region: region,
        phone: phone,
      },
    };
  }

  function setHint(text, tone) {
    elements.hint.textContent = text;
    elements.hint.classList.remove('is-error', 'is-active');
    if (tone === 'error') {
      elements.hint.classList.add('is-error');
    }
    if (tone === 'active') {
      elements.hint.classList.add('is-active');
    }
  }

  function setFormNote(text, tone) {
    elements.formNote.textContent = text;
    elements.formNote.classList.remove('is-error', 'is-success');
    if (tone === 'error') {
      elements.formNote.classList.add('is-error');
    }
    if (tone === 'success') {
      elements.formNote.classList.add('is-success');
    }
  }

  function scrollToBottom() {
    elements.messages.scrollTop = elements.messages.scrollHeight;
  }

  function plainTextFromHtml(html) {
    const temp = document.createElement('div');
    temp.innerHTML = html;
    return (temp.textContent || temp.innerText || '').trim();
  }

  function selectPreferredVoice() {
    if (!('speechSynthesis' in window) || typeof window.speechSynthesis.getVoices !== 'function') {
      state.preferredVoice = null;
      return;
    }

    const voices = window.speechSynthesis.getVoices();
    if (!Array.isArray(voices) || !voices.length) {
      state.preferredVoice = null;
      return;
    }

    const femaleHints = [
      'female', 'woman', 'girl', 'zira', 'aria', 'samantha', 'victoria', 'karen',
      'natasha', 'veena', 'moira', 'serena', 'susan', 'hazel', 'allison', 'ava',
      'jenny', 'sonia', 'neerja', 'priya', 'raveena', 'heera', 'swara', 'aditi'
    ];

    const qualityHints = ['google', 'microsoft', 'neural', 'natural', 'online'];
    const chromeVoicePriority = ['zira', 'microsoft zira', 'microsoft zira desktop', 'zira desktop', 'google us english', 'google uk english female'];

    const scoredVoices = voices.map(function (voice) {
      const haystack = [
        voice.name || '',
        voice.voiceURI || '',
        voice.lang || ''
      ].join(' ').toLowerCase();

      let score = 0;

      chromeVoicePriority.forEach(function (hint, index) {
        if (haystack.indexOf(hint) !== -1) {
          score += 30 - (index * 4);
        }
      });

      if (state.language === 'hi') {
        if (/^hi(-|_)?in/i.test(voice.lang || '')) {
          score += 24;
        } else if (/^hi/i.test(voice.lang || '')) {
          score += 18;
        } else if (/^en(-|_)?in/i.test(voice.lang || '')) {
          score += 6;
        }
      } else {
        if (/^en(-|_)?in/i.test(voice.lang || '')) {
          score += 18;
        } else if (/^en/i.test(voice.lang || '')) {
          score += 12;
        } else if (/^hi(-|_)?in/i.test(voice.lang || '')) {
          score += 4;
        }
      }

      if (femaleHints.some(function (hint) { return haystack.indexOf(hint) !== -1; })) {
        score += 10;
      }

      if (qualityHints.some(function (hint) { return haystack.indexOf(hint) !== -1; })) {
        score += 6;
      }

      if (voice.default) {
        score += 2;
      }

      return { voice: voice, score: score };
    }).sort(function (a, b) {
      return b.score - a.score;
    });

    state.preferredVoice = scoredVoices.length ? scoredVoices[0].voice : null;
  }

  function speak(html) {
    if (!state.autoSpeak || !state.speechEnabled) {
      return;
    }

    const text = plainTextFromHtml(html);
    if (!text) {
      return;
    }

    window.speechSynthesis.cancel();
    const utterance = new SpeechSynthesisUtterance(text);
    const selectedVoice = state.preferredVoice;
    utterance.lang = selectedVoice && selectedVoice.lang ? selectedVoice.lang : getRecognitionLang();
    utterance.rate = state.language === 'hi' ? 0.9 : 0.96;
    utterance.pitch = state.language === 'hi' ? 1.0 : 1.08;
    utterance.volume = 1;

    if (selectedVoice) {
      utterance.voice = selectedVoice;
    }

    window.speechSynthesis.speak(utterance);
  }

  function updateSpeakButton() {
    if (!elements.speakToggle) {
      return;
    }

    if (!state.speechEnabled) {
      elements.speakToggle.style.display = 'none';
      return;
    }

    elements.speakToggle.style.display = '';
    elements.speakToggle.classList.toggle('is-active', state.autoSpeak);
    elements.speakToggle.querySelector('.material-symbols-outlined').textContent = state.autoSpeak ? 'volume_up' : 'volume_off';
    elements.speakToggle.setAttribute('aria-label', state.autoSpeak ? t('speakOffAria') : t('speakOnAria'));
    elements.newChat.setAttribute('aria-label', t('newChatAria'));
    elements.close.setAttribute('aria-label', t('closeAria'));
  }

  function syncReadyState() {
    elements.readyState.hidden = !state.started || elements.messages.children.length > 0;
  }

  function autoResizeInput() {
    elements.input.style.height = 'auto';
    elements.input.style.height = Math.min(elements.input.scrollHeight, 112) + 'px';
  }

  function setComposerEnabled(enabled) {
    elements.input.disabled = !enabled;
    elements.mic.disabled = !enabled || !state.voiceInputSupported;
    elements.send.disabled = !enabled;
    elements.input.placeholder = enabled ? t('inputPlaceholderReady') : t('inputPlaceholderLocked');
  }

  function resetVoiceCaptureState() {
    state.isProcessingVoice = false;
    state.shouldSubmitVoiceOnEnd = false;
    state.voiceBaseText = '';
    state.recognitionFinalText = '';
    state.recognitionInterimText = '';
    state.recognitionHadResult = false;
    state.lastRecognitionError = '';
  }

  function buildVoiceTranscript() {
    return normalizeText([
      state.voiceBaseText,
      state.recognitionFinalText,
      state.recognitionInterimText,
    ].filter(Boolean).join(' '));
  }

  function sanitizeVoiceTranscript(value) {
    let transcript = normalizeText(value);
    if (!transcript) {
      return '';
    }

    transcript = transcript
      .replace(/^(hey|hi|hello|namaste)\s+(assistant|chatbot|guide)\s*/i, '')
      .replace(/^(नमस्ते|हेलो|हाय)\s+(असिस्टेंट|चैटबॉट|गाइड)\s*/i, '')
      .replace(/\b(send( this)? (message|prompt)|send it|send now|submit( this)? (message|prompt)|submit it|okay send|ok send)\b[\s.!?]*$/i, '')
      .replace(/(इसे भेजो|भेज दो|संदेश भेजो|मैसेज भेजो|सबमिट करो)[\s.!?]*$/i, '');

    return normalizeText(transcript);
  }

  function updateMicButton() {
    if (!elements.mic) {
      return;
    }

    const icon = elements.mic.querySelector('.material-symbols-outlined');
    elements.mic.classList.remove('is-listening', 'is-processing');
    if (elements.field) {
      elements.field.classList.remove('is-listening');
    }

    if (!state.voiceInputSupported) {
      elements.mic.disabled = true;
      icon.textContent = 'mic_off';
      elements.mic.setAttribute('aria-label', t('micUnavailableAria'));
      return;
    }

    if (state.isListening) {
      elements.mic.disabled = false;
      icon.textContent = 'graphic_eq';
      elements.mic.classList.add('is-listening');
      if (elements.field) {
        elements.field.classList.add('is-listening');
      }
      elements.mic.setAttribute('aria-label', t('micStopAria'));
      return;
    }

    if (state.isProcessingVoice) {
      elements.mic.disabled = true;
      icon.textContent = 'hourglass_top';
      elements.mic.classList.add('is-processing');
      elements.mic.setAttribute('aria-label', t('micFinishingAria'));
      return;
    }

    elements.mic.disabled = !state.started;
    icon.textContent = 'mic';
    elements.mic.setAttribute('aria-label', t('micStartAria'));
  }

  function setupRecognition() {
    if (!state.voiceInputSupported) {
      updateMicButton();
      return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = getRecognitionLang();
    recognition.interimResults = true;
    recognition.continuous = true;

    recognition.onstart = function () {
      state.isListening = true;
      state.isProcessingVoice = false;
      state.lastRecognitionError = '';
      updateMicButton();
      setHint(t('hintListeningStart'), 'active');
    };

    recognition.onresult = function (event) {
      let finalTranscript = '';
      let interimTranscript = '';

      for (let index = 0; index < event.results.length; index += 1) {
        const result = event.results[index];
        const spokenText = result && result[0] && result[0].transcript ? normalizeText(result[0].transcript) : '';
        if (!spokenText) {
          continue;
        }

        if (result.isFinal) {
          finalTranscript += (finalTranscript ? ' ' : '') + spokenText;
        } else {
          interimTranscript += (interimTranscript ? ' ' : '') + spokenText;
        }
      }

      state.recognitionFinalText = normalizeText(finalTranscript);
      state.recognitionInterimText = normalizeText(interimTranscript);
      state.recognitionHadResult = !!(state.recognitionFinalText || state.recognitionInterimText);

      elements.input.value = buildVoiceTranscript();
      autoResizeInput();
      setHint(state.recognitionInterimText ? t('hintListeningContinue') : t('hintVoiceFinishingCaptured'), 'active');
    };

    recognition.onspeechend = function () {
      if (!state.isListening) {
        return;
      }

      state.isProcessingVoice = true;
      updateMicButton();
      setHint(t('hintVoiceFinishing'), 'active');

      try {
        recognition.stop();
      } catch (error) {
        // Ignore stop timing issues.
      }
    };

    recognition.onerror = function (event) {
      state.lastRecognitionError = event && event.error ? event.error : 'error';
      state.isListening = false;
      state.isProcessingVoice = false;
      updateMicButton();

      if (state.lastRecognitionError === 'aborted') {
        resetVoiceCaptureState();
        return;
      }

      if (state.lastRecognitionError === 'not-allowed' || state.lastRecognitionError === 'service-not-allowed') {
        setHint(t('hintMicPermission'), 'error');
        return;
      }

      if (state.lastRecognitionError === 'no-speech') {
        setHint(t('hintNoSpeech'), 'error');
        resetVoiceCaptureState();
        return;
      }

      if (state.lastRecognitionError === 'audio-capture') {
        setHint(t('hintNoMic'), 'error');
        resetVoiceCaptureState();
        return;
      }

      setHint(t('hintVoiceStartError'), 'error');
      resetVoiceCaptureState();
    };

    recognition.onend = function () {
      state.isListening = false;
      updateMicButton();

      if (state.lastRecognitionError && state.lastRecognitionError !== 'aborted') {
        state.isProcessingVoice = false;
        updateMicButton();
        return;
      }

      const transcript = sanitizeVoiceTranscript(buildVoiceTranscript());
      const shouldAutoSend = state.shouldSubmitVoiceOnEnd && state.recognitionHadResult && !!transcript;

      state.isProcessingVoice = false;
      updateMicButton();

      if (!shouldAutoSend) {
        if (!transcript && state.started) {
          setHint(t('noClearVoiceMessage'), 'error');
        } else if (transcript) {
          elements.input.value = transcript;
          autoResizeInput();
          setHint(t('hintVoiceCapturedEdit'), 'active');
        }
        resetVoiceCaptureState();
        return;
      }

      elements.input.value = transcript;
      autoResizeInput();
      setHint(t('hintVoiceSending'), 'active');
      resetVoiceCaptureState();

      window.setTimeout(function () {
        submitComposer();
      }, 120);
    };

    state.recognition = recognition;
    updateMicButton();
  }

  function openProfileForm() {
    if (state.profile) {
      elements.profileForm.elements.name.value = state.profile.name || '';
      elements.profileForm.elements.email.value = state.profile.email || '';
      elements.profileForm.elements.region.value = state.profile.region || '';
      elements.profileForm.elements.phone.value = state.profile.phone || '';
    }
    setFormNote(t('formNoteDefault'));
  }

  function syncGate() {
    elements.gate.hidden = state.started;
    setComposerEnabled(state.started);

    if (state.profile) {
      elements.gateCopy.textContent = t('gateCopySaved');
      openProfileForm();
    } else {
      elements.gateCopy.textContent = t('gateCopyDefault');
      openProfileForm();
    }

    syncReadyState();
  }

  function setOpen(isOpen) {
    if (!isOpen) {
      stopActiveListening();
    }

    elements.shell.classList.toggle('cyi-chatbot--open', isOpen);
    if (isOpen) {
      window.setTimeout(function () {
        if (state.started) {
          elements.input.focus();
          scrollToBottom();
        }
      }, 80);
      return;
    }

    showTeaser();
  }

  function hideTeaser() {
    elements.shell.classList.remove('cyi-chatbot--teaser-visible');
  }

  function showTeaser() {
    elements.shell.classList.add('cyi-chatbot--teaser-visible');
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
        if (action.type === 'prompt' && action.prompt) {
          handleUserMessage(action.prompt, true);
          return;
        }
        if (action.type === 'lead') {
          submitInquiryAction(action);
        }
      });
      actionsWrap.appendChild(button);
    });

    wrapper.appendChild(actionsWrap);
  }

  function addMessage(role, html, actions, options) {
    const wrapper = document.createElement('article');
    wrapper.className = 'cyi-chatbot__message cyi-chatbot__message--' + role;

    const bubble = document.createElement('div');
    bubble.className = 'cyi-chatbot__bubble';
    bubble.innerHTML = html;
    wrapper.appendChild(bubble);

    appendMessageActions(wrapper, actions);
    elements.messages.appendChild(wrapper);
    syncReadyState();
    scrollToBottom();

    if (!options || options.remember !== false) {
      rememberMessage(role, html, actions);
    }

    if (role === 'bot' && (!options || options.speak !== false)) {
      speak(html);
    }

    return wrapper;
  }

  function restoreHistory() {
    if (!Array.isArray(state.history) || !state.history.length) {
      return;
    }

    elements.messages.innerHTML = '';
    state.history.forEach(function (entry) {
      if (!entry || !entry.role || !entry.html) {
        return;
      }
      addMessage(entry.role, entry.html, entry.actions || [], {
        remember: false,
        speak: false,
      });
    });
  }

  function addTyping() {
    const wrapper = document.createElement('article');
    wrapper.className = 'cyi-chatbot__message cyi-chatbot__message--bot';
    wrapper.dataset.typing = 'true';
    wrapper.innerHTML = '<div class="cyi-chatbot__bubble"><div class="cyi-chatbot__thinking"><span class="cyi-chatbot__typing" aria-hidden="true"><span></span><span></span><span></span></span><span>' + escapeHtml(t('typing')) + '</span></div></div>';
    elements.messages.appendChild(wrapper);
    syncReadyState();
    scrollToBottom();
    return wrapper;
  }

  function removeTyping(node) {
    if (node && node.parentNode) {
      node.parentNode.removeChild(node);
    }
  }

  function paragraphs(lines) {
    return lines.map(function (line) {
      return '<p>' + line + '</p>';
    }).join('');
  }

  function buildResponse(rawMessage) {
    const input = String(rawMessage || '').toLowerCase();
    const context = state.context || { routes: {}, brand: {}, online_courses: [], offline_courses: [], workshops: [], jobs: [], quick_answers: {} };
    const matchedCourses = findMatchingCourses(input, context);
    const collections = getCourseCollections(context);
    const hasTopicIntent = containsAny(input, []
      .concat(INTENTS.training)
      .concat(INTENTS.mentorship)
      .concat(INTENTS.workshop)
      .concat(INTENTS.placement)
      .concat(INTENTS.contact)
      .concat(INTENTS.offline)
      .concat(INTENTS.certificate)
      .concat(INTENTS.auth));
    const wantsInquiry = containsAny(input, INTENTS.inquiry);
    const navigationTarget = detectNavigationRequest(input) ? getNavigationTarget(input, context, matchedCourses) : null;

    if (navigationTarget) {
      return {
        html: paragraphs([
          t('navTakingTo', { label: escapeHtml(navigationTarget.label) }),
          t('navRedirectLine')
        ]),
        actions: [
          { label: t('navOpenNow'), type: 'link', href: navigationTarget.href }
        ],
        navigateTo: navigationTarget.href,
      };
    }

    if (matchedCourses.length) {
      const matchedCourse = matchedCourses[0];
      const summary = escapeHtml(buildCourseSummary(matchedCourse) || t('summaryDetailsFallback'));
      return {
        html: paragraphs([
          t('replyMatchedCourse1', { title: escapeHtml(matchedCourse.title) }),
          t('replyMatchedCourse2', { summary: summary })
        ]),
        actions: buildCourseButtons(matchedCourses, t('buttonAllTrainingPrograms'), context.routes.courses)
      };
    }

    if (wantsInquiry) {
      const leadTopic = inferLeadTopic(input, matchedCourses);
      const details = extractLeadDetails(rawMessage, context, matchedCourses);
      return {
        html: paragraphs([t('replyInquiryTeam')]),
        actions: [
          {
            label: t('buttonSendInquiry'),
            type: 'lead',
            topic: leadTopic,
            subject: buildLeadSubject(leadTopic, details),
            courseId: details.courseId || null,
            courseInterest: details.courseInterest || null,
            message: rawMessage
          }
        ]
      };
    }

    if (containsAny(input, INTENTS.certificate)) {
      return {
        html: paragraphs([
          t('replyCertificate1'),
          escapeHtml(context.quick_answers.certificates || '')
        ]),
        actions: [
          context.routes.login ? { label: t('buttonStudentLogin'), type: 'link', href: context.routes.login } : null,
          { label: t('buttonTrainingPrograms'), type: 'prompt', prompt: localizedPrompt('training') }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, INTENTS.mentorship)) {
      return {
        html: paragraphs([
          t('replyMentorship1'),
          t('replyMentorship2')
        ]),
        actions: [
          context.routes.mentorship ? { label: t('buttonOpenMentorship'), type: 'link', href: context.routes.mentorship } : null,
          { label: t('buttonRequestMentorship'), type: 'lead', topic: 'mentorship', subject: buildLeadSubject('mentorship'), message: rawMessage }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, INTENTS.workshop)) {
      return {
        html: paragraphs([
          t('replyWorkshop1'),
          t('replyWorkshop2', { items: escapeHtml(summarizeCourses(context.workshops)) })
        ]),
        actions: [
          context.routes.workshop ? { label: t('buttonOpenWorkshopPage'), type: 'link', href: context.routes.workshop } : null,
          { label: t('buttonWorkshopInquiry'), type: 'lead', topic: 'workshop', subject: buildLeadSubject('workshop'), message: rawMessage }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, INTENTS.placement)) {
      return {
        html: paragraphs([
          t('replyPlacement1'),
          t('replyPlacement2', {
            text: escapeHtml(context.quick_answers.placement || t('quickAnswerPlacementFallback'))
          })
        ]),
        actions: [
          context.routes.placement ? { label: t('buttonPlacementPage'), type: 'link', href: context.routes.placement } : null,
          { label: t('buttonPlacementHelp'), type: 'lead', topic: 'placement', subject: buildLeadSubject('placement'), message: rawMessage }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, INTENTS.contact)) {
      return {
        html: paragraphs([
          t('replyContact1', {
            email: escapeHtml(context.brand.email || 'codeinyourself@gmail.com'),
            phone: escapeHtml(context.brand.phone || '+91 90164 27165')
          })
        ]),
        actions: [
          context.routes.contact ? { label: t('buttonContactPage'), type: 'link', href: context.routes.contact } : null,
          { label: t('buttonSendMessage'), type: 'lead', topic: 'support', subject: buildLeadSubject('support'), message: rawMessage }
        ].filter(Boolean)
      };
    }

    if (containsAny(input, INTENTS.offline)) {
      return {
        html: paragraphs([
          t('replyOffline1'),
          t('replyOffline2', { items: escapeHtml(summarizeCourses(collections.offline)) })
        ]),
        actions: buildCourseButtons(
          collections.offline,
          t('buttonOfflineTrainingPrograms'),
          context.routes.courses ? context.routes.courses + '?mode=offline' : null
        )
      };
    }

    if (containsAny(input, INTENTS.training)) {
      const featuredCourses = getAllCourses(context).slice(0, 3);
      return {
        html: paragraphs([
          t('replyPrograms1'),
          t('replyPrograms2', { items: escapeHtml(summarizeCourses(getAllCourses(context))) })
        ]),
        actions: buildCourseButtons(featuredCourses, t('buttonBrowseTrainingPrograms'), context.routes.courses).concat([
          { label: t('buttonTrainingGuidance'), type: 'lead', topic: 'course', subject: buildLeadSubject('course'), message: rawMessage }
        ])
      };
    }

    if (containsAny(input, INTENTS.auth)) {
      return {
        html: paragraphs([t('replyLoginRegister')]),
        actions: [
          context.routes.login ? { label: t('buttonLogin'), type: 'link', href: context.routes.login } : null,
          context.routes.register ? { label: t('buttonRegister'), type: 'link', href: context.routes.register } : null
        ].filter(Boolean)
      };
    }

    if (!hasTopicIntent && containsAny(input, INTENTS.greeting)) {
      return {
        html: paragraphs([t('replyGreeting')]),
        actions: [
          { label: t('buttonTrainingPrograms'), type: 'prompt', prompt: localizedPrompt('training') },
          { label: t('buttonMentorship'), type: 'prompt', prompt: localizedPrompt('mentorship') },
          { label: t('buttonWorkshop'), type: 'prompt', prompt: localizedPrompt('workshop') }
        ]
      };
    }

    return {
      html: paragraphs([
        t('replyFallback1'),
        t('replyFallback2')
      ]),
      actions: [
        { label: t('buttonTrainingPrograms'), type: 'prompt', prompt: localizedPrompt('training') },
        { label: t('buttonMentorship'), type: 'prompt', prompt: localizedPrompt('mentorship') },
        { label: t('buttonWorkshop'), type: 'prompt', prompt: localizedPrompt('workshop') },
        { label: t('buttonSupport'), type: 'prompt', prompt: localizedPrompt('support') }
      ]
    };
  }

  function postInquiry(payload) {
    return fetch(config.inquiryUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': config.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload)
    }).then(function (response) {
      return response.json().catch(function () {
        return {};
      }).then(function (data) {
        if (!response.ok) {
          throw new Error(data.message || data.error || t('unableToSaveNow'));
        }
        return data;
      });
    });
  }

  function submitProfileForm(event) {
    event.preventDefault();
    event.stopPropagation();

    const validation = validateProfile({
      name: elements.profileForm.elements.name.value,
      email: elements.profileForm.elements.email.value,
      region: elements.profileForm.elements.region.value,
      phone: elements.profileForm.elements.phone.value,
    });

    if (!validation.ok) {
      setFormNote(validation.message, 'error');
      setHint(validation.message, 'error');
      return;
    }

    setFormNote(t('hintSavingDetails'), 'success');
    setHint(t('hintSavingDetails'), 'active');

    postInquiry({
      name: validation.values.name,
      email: validation.values.email,
      region: validation.values.region,
      phone: validation.values.phone,
      message: t('saveProfileMessage'),
      topic: 'general',
      subject: t('saveProfileSubject'),
      intent: 'chatbot-profile',
      inquiry_kind: 'profile',
      page_url: window.location.pathname + window.location.search,
      source_page: 'chatbot-widget',
      language: state.language,
    }).then(function (payload) {
      saveProfile({
        name: validation.values.name,
        email: validation.values.email,
        region: validation.values.region,
        phone: validation.values.phone,
        contactId: payload.contact_id || null,
      });

      state.started = true;
      syncGate();
      setHint(t('profileSavedSuccess'), 'active');
      elements.input.focus();
    }).catch(function (error) {
      setFormNote(error.message || t('profileSaveError'), 'error');
      setHint(error.message || t('profileSaveError'), 'error');
    });
  }

  function submitInquiryAction(action) {
    if (!state.profile) {
      state.started = false;
      syncGate();
      openProfileForm();
      setHint(t('hintSaveDetailsForInquiry'), 'error');
      return;
    }

    const typingNode = addTyping();
    const fallbackMessage = state.lastUserMessage || action.message || action.subject || t('inquiryFollowUp');

    postInquiry({
      name: state.profile.name,
      email: state.profile.email,
      region: state.profile.region,
      phone: state.profile.phone,
      message: fallbackMessage,
      topic: action.topic || 'general',
      subject: action.subject || t('inquirySubjectFallback'),
      intent: action.topic || 'general',
      inquiry_kind: 'inquiry',
      course_id: action.courseId || null,
      course_interest: action.courseInterest || null,
      page_url: window.location.pathname + window.location.search,
      source_page: 'chatbot-widget',
      language: state.language,
    }).then(function () {
      removeTyping(typingNode);
      addMessage('bot', paragraphs([t('inquirySuccess'), t('inquirySuccessTeam')]));
    }).catch(function (error) {
      removeTyping(typingNode);
      addMessage('bot', '<p>' + escapeHtml(error.message || t('inquiryError')) + '</p>');
    });
  }

  function handleUserMessage(rawMessage, fromAction) {
    const message = normalizeText(rawMessage);
    if (!message) {
      return;
    }

    if (!state.started) {
      state.started = false;
      syncGate();
      openProfileForm();
      setHint(t('hintSaveDetailsToStart'), 'error');
      return;
    }

    if (!fromAction) {
      addMessage('user', '<p>' + nl2br(message) + '</p>');
    }

    state.lastUserMessage = message;
    const typingNode = addTyping();

    window.setTimeout(function () {
      removeTyping(typingNode);
      const response = buildResponse(message);
      addMessage('bot', response.html, response.actions || []);
      if (response.navigateTo) {
        window.setTimeout(function () {
          window.location.href = response.navigateTo;
        }, 700);
      }
    }, 280);
  }

  function submitComposer(event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    const value = normalizeText(elements.input.value);
    if (!value) {
      return;
    }

    elements.input.value = '';
    autoResizeInput();
    handleUserMessage(value, false);
  }

  function resetChat() {
    elements.messages.innerHTML = '';
    state.lastUserMessage = '';
    state.started = !!state.profile;
    resetVoiceCaptureState();
    clearHistory();
    syncGate();
    setHint(state.started ? t('hintAsk') : t('hintLocked'));
    elements.input.value = '';
    autoResizeInput();
  }

  function fetchContext() {
    if (!config.contextUrl) {
      return Promise.resolve();
    }

    return fetch(config.contextUrl, { headers: { Accept: 'application/json' } })
      .then(function (response) {
        if (!response.ok) {
          throw new Error(t('unableToLoadContext'));
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

  elements.launcher.addEventListener('click', function (event) {
    event.preventDefault();
    setOpen(true);
  });

  elements.teaser.addEventListener('click', function (event) {
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
    if (!state.autoSpeak) {
      window.speechSynthesis.cancel();
    }
  });

  Array.prototype.forEach.call(elements.langButtons, function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      setLanguage(button.getAttribute('data-lang-toggle'));
    });
  });

  elements.mic.addEventListener('click', function (event) {
    event.preventDefault();
    if (!state.voiceInputSupported || !state.recognition || elements.mic.disabled) {
      setHint(t('hintVoiceUnavailable'), 'error');
      return;
    }

    if (state.isListening) {
      state.isProcessingVoice = true;
      updateMicButton();
      setHint(t('hintVoiceFinishing'), 'active');
      state.recognition.stop();
      return;
    }

    try {
      state.voiceBaseText = normalizeText(elements.input.value);
      state.recognitionFinalText = '';
      state.recognitionInterimText = '';
      state.recognitionHadResult = false;
      state.lastRecognitionError = '';
      state.shouldSubmitVoiceOnEnd = true;
      state.recognition.lang = getRecognitionLang();
      autoResizeInput();
      state.recognition.start();
    } catch (error) {
      setHint(t('hintVoiceBusy'), 'error');
    }
  });

  elements.profileForm.addEventListener('submit', submitProfileForm);
  elements.form.addEventListener('submit', submitComposer);
  elements.input.addEventListener('input', autoResizeInput);
  elements.input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      submitComposer(event);
    }
  });

  updateLanguageUI();
  restoreHistory();
  selectPreferredVoice();
  if ('speechSynthesis' in window && typeof window.speechSynthesis.addEventListener === 'function') {
    window.speechSynthesis.addEventListener('voiceschanged', selectPreferredVoice);
  }
  setupRecognition();
  autoResizeInput();
  if (state.started) {
    setHint(state.history.length ? t('hintHistoryReady') : t('hintAsk'), 'active');
  } else {
    setHint(t('hintLocked'));
  }
  window.setTimeout(showTeaser, 900);
  fetchContext();
})();
