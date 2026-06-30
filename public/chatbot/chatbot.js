(function () {
  const root = document.getElementById('cyi-chatbot-root');
  if (!root) {
    return;
  }

  const PROFILE_KEY = 'cyi-chatbot-profile-v2';
  const HISTORY_KEY = 'cyi-chatbot-history-v1';
  const LANGUAGE_KEY = 'cyi-chatbot-language-v1';
  const AUTOSPEAK_KEY = 'cyi-chatbot-autospeak-v2';
  const HISTORY_LIMIT = 24;
  const VOICE_AUTO_SEND_SILENCE_MS = 2500;
  const ownerAvatar = String('https://res.cloudinary.com/dqxg5hhfi/image/upload/v1777094905/chatbot2_t3owzh.gif').replace(/"/g, '&quot;');
  const ownerName = String(root.dataset.ownerName || 'CodeInYourself Guide').replace(/"/g, '&quot;');

  const config = {
    contextUrl: root.dataset.contextUrl || '',
    messageUrl: root.dataset.messageUrl || '',
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
      inquirySuccessWithId: 'Inquiry ID: <strong>{{id}}</strong>.',
      inquirySuccessTeam: 'Our HR team will contact you as soon as possible. Thanks for raising inquiry.',
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
      replyPublicPages1: 'Here are the public pages you can open right now.',
      replyPublicPages2: 'Tap any page below and I will redirect you.',
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
      replyMentorshipBookingAskDate: 'Please share your preferred mentorship date and a 30-minute slot.',
      replyMentorshipBookingAskTime: 'Please share a valid 30-minute slot on {{date}}.',
      replyMentorshipBookingAskDateOnly: 'Please share the mentorship date in this format: YYYY-MM-DD.',
      replyMentorshipBookingRules: 'Available slots are only between 10:00 AM to 12:00 PM and 2:00 PM to 5:00 PM, in 30-minute gaps.',
      replyMentorshipBookingExamples: 'Examples: 10:00 AM to 10:30 AM, 10:30 AM to 11:00 AM, 2:00 PM to 2:30 PM, 4:30 PM to 5:00 PM.',
      replyMentorshipBookingInvalidSlot: 'That slot is outside the available mentorship windows.',
      replyMentorshipBookingInvalidDuration: 'Mentorship booking must be exactly 30 minutes.',
      replyMentorshipBookingInvalidStep: 'Slot start and end time must be in 30-minute steps.',
      replyMentorshipBookingInvalidPastDate: 'Please choose a current or future date.',
      replyMentorshipBookingConfirmed1: 'Your mentorship booking request is ready.',
      replyMentorshipBookingConfirmedUser: 'I booked the free mentorship for <strong>{{name}}</strong>.',
      replyMentorshipBookingConfirmed2: 'Booking ID: <strong>{{bookingId}}</strong>.',
      replyMentorshipBookingConfirmed3: 'Date: {{date}} | Slot: {{slot}}.',
      buttonMentorshipBookingRequest: 'Book Mentorship Slot',
      buttonShowSlots: 'Show Slot Rules',
      replyWorkshop1: 'The workshop section is live.',
      replyWorkshop2: 'Current workshop options: {{items}}.',
      replyWorkshopNone: 'No active workshop is listed right now. You can still raise a workshop inquiry.',
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
      subjectMentorship: 'Mentorship request{{interest}}',
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
      inquirySuccessWithId: 'Inquiry ID: <strong>{{id}}</strong>.',
      inquirySuccessTeam: 'Our HR team will contact you as soon as possible. Thanks for raising inquiry.',
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
      replyPublicPages1: 'यहां सभी पब्लिक पेज हैं जिन्हें आप अभी खोल सकते हैं।',
      replyPublicPages2: 'नीचे किसी भी पेज पर टैप करें, मैं तुरंत रीडायरेक्ट कर दूंगा।',
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
      replyMentorshipBookingAskDate: 'कृपया मेंटरशिप के लिए अपनी पसंदीदा तारीख और 30 मिनट का स्लॉट बताएं।',
      replyMentorshipBookingAskTime: 'कृपया {{date}} के लिए सही 30 मिनट का स्लॉट बताएं।',
      replyMentorshipBookingAskDateOnly: 'कृपया मेंटरशिप की तारीख इस फॉर्मेट में दें: YYYY-MM-DD.',
      replyMentorshipBookingRules: 'उपलब्ध स्लॉट केवल 10:00 AM से 12:00 PM और 2:00 PM से 5:00 PM तक, 30 मिनट के अंतर में हैं।',
      replyMentorshipBookingExamples: 'उदाहरण: 10:00 AM से 10:30 AM, 10:30 AM से 11:00 AM, 2:00 PM से 2:30 PM, 4:30 PM से 5:00 PM.',
      replyMentorshipBookingInvalidSlot: 'यह स्लॉट उपलब्ध मेंटरशिप समय सीमा के बाहर है।',
      replyMentorshipBookingInvalidDuration: 'मेंटरशिप बुकिंग बिल्कुल 30 मिनट की होनी चाहिए।',
      replyMentorshipBookingInvalidStep: 'स्लॉट का शुरू और खत्म समय 30 मिनट के स्टेप में होना चाहिए।',
      replyMentorshipBookingInvalidPastDate: 'कृपया आज या भविष्य की तारीख चुनें।',
      replyMentorshipBookingConfirmed1: 'आपकी मेंटरशिप बुकिंग रिक्वेस्ट तैयार है।',
      replyMentorshipBookingConfirmedUser: 'मैंने <strong>{{name}}</strong> के लिए फ्री मेंटरशिप बुक कर दी है।',
      replyMentorshipBookingConfirmed2: 'बुकिंग आईडी: <strong>{{bookingId}}</strong>.',
      replyMentorshipBookingConfirmed3: 'तारीख: {{date}} | स्लॉट: {{slot}}.',
      buttonMentorshipBookingRequest: 'मेंटरशिप स्लॉट बुक करें',
      buttonShowSlots: 'स्लॉट नियम देखें',
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
    booking: ['book', 'booking', 'schedule', 'slot', 'appointment', 'time slot', 'book mentorship', 'free mentorship', 'reschedule', 'बुक', 'बुकिंग', 'शेड्यूल', 'स्लॉट', 'समय', 'अपॉइंटमेंट'],
    workshopAvailability: ['available workshop', 'available workshops', 'upcoming workshop', 'upcoming workshops', 'workshop details', 'workshop timing', 'workshop schedule', 'उपलब्ध वर्कशॉप', 'आने वाले वर्कशॉप', 'वर्कशॉप विवरण'],
    placement: ['placement', 'placements', 'placement support', 'job', 'jobs', 'प्लेसमेंट', 'जॉब', 'नौकरी', 'प्लेसमेंट सपोर्ट'],
    contact: ['contact', 'support', 'human', 'call', 'team', 'कॉन्टैक्ट', 'संपर्क', 'सपोर्ट', 'टीम', 'कॉल', 'बात'],
    offline: ['offline', 'classroom', 'ऑफलाइन', 'क्लासरूम'],
    certificate: ['certificate', 'certification', 'सर्टिफिकेट', 'प्रमाणपत्र', 'सर्टिफिकेशन'],
    auth: ['login', 'register', 'signup', 'sign in', 'sign up', 'लॉगिन', 'रजिस्टर', 'साइन इन', 'साइन अप'],
    greeting: ['hello', 'hi', 'hey', 'namaste', 'नमस्ते', 'हेलो', 'हाय'],
    inquiry: ['contact me', 'call me', 'reach me', 'get in touch', 'book a call', 'book call', 'book demo', 'i need help', 'i need support', 'i want support', 'i want admission', 'admission help', 'connect me', 'team contact', 'मुझसे संपर्क', 'मुझे कॉल', 'मुझसे बात', 'मदद चाहिए', 'सपोर्ट चाहिए', 'एडमिशन चाहिए', 'टीम से जोड़ो', 'टीम से बात'],
    navigation: ['go to', 'take me to', 'open', 'redirect me to', 'navigate to', 'show me', 'bring me to', 'send me to', 'खोलो', 'ले चलो', 'दिखाओ', 'ओपन', 'भेजो', 'जाना है'],
    pageHints: ['page', 'homepage', 'home page', 'public page', 'public pages', 'all pages', 'site page', 'website page', 'पेज', 'होम पेज', 'सभी पेज', 'पब्लिक पेज']
  };

  const regionDialCodes = {
    india: '+91',
    bharat: '+91',
    'भारत': '+91',
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
  const initialAutoSpeak = loadAutoSpeak();

  const state = {
    context: null,
    profile: initialProfile,
    started: !!initialProfile,
    hasDismissedTeaser: false,
    lastUserMessage: '',
    history: initialHistory,
    language: initialLanguage,
    speechEnabled: 'speechSynthesis' in window,
    autoSpeak: initialAutoSpeak,
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
    voiceSilenceTimer: null,
    preferredVoices: { en: null, hi: null },
    preferredVoice: null,
    speechPrimed: false,
    speechJobId: 0,
    speechRetryTimer: null,
    awaitingMentorshipSchedule: false,
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

  function loadAutoSpeak() {
    try {
      return window.localStorage.getItem(AUTOSPEAK_KEY) !== '0';
    } catch (error) {
      return true;
    }
  }

  function saveAutoSpeak(enabled) {
    try {
      window.localStorage.setItem(AUTOSPEAK_KEY, enabled ? '1' : '0');
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
    stopSpeechPlayback();

    state.language = nextLanguage;
    state.speechPrimed = false;
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
    if (containsAny(input, INTENTS.navigation)) {
      return true;
    }

    if (!containsAny(input, INTENTS.pageHints)) {
      return false;
    }

    const context = state.context || { routes: {} };
    return !!getNavigationTarget(input, context, []);
  }

  function buildNavigationTargets(context) {
    return [
      { label: t('labelHomePage'), href: context.routes.home, terms: ['home', 'homepage', 'main page', 'होम'] },
      { label: t('labelTrainingProgramsPage'), href: context.routes.courses, terms: INTENTS.training.concat(['catalog', 'कैटलॉग']) },
      { label: t('labelCareerPathsPage'), href: context.routes.career_paths, terms: ['career path', 'career paths', 'career roadmap', 'pathway', 'कैरियर पाथ', 'करियर पाथ', 'कैरियर रोडमैप'] },
      { label: t('labelCareersPage'), href: context.routes.careers, terms: ['career', 'careers', 'job opening', 'jobs', 'कैरियर्स', 'जॉब्स'] },
      { label: t('labelMentorshipPage'), href: context.routes.mentorship, terms: INTENTS.mentorship },
      { label: t('labelWorkshopPage'), href: context.routes.workshop, terms: INTENTS.workshop },
      { label: t('labelPlacementPage'), href: context.routes.placement, terms: INTENTS.placement.concat(['placement help', 'placement page', 'placement assistance', 'career support']) },
      { label: t('labelContactPage'), href: context.routes.contact, terms: INTENTS.contact.concat(['contact page', 'कॉन्टैक्ट पेज']) },
      { label: t('labelAboutPage'), href: context.routes.about, terms: ['about', 'about us', 'अबाउट'] },
      { label: t('labelCorporateTrainingPage'), href: context.routes.corporate_training, terms: ['corporate training', 'company training', 'कॉर्पोरेट ट्रेनिंग'] },
      { label: t('labelLoginPage'), href: context.routes.login, terms: ['login', 'sign in', 'लॉगिन'] },
      { label: t('labelRegisterPage'), href: context.routes.register, terms: ['register', 'signup', 'sign up', 'रजिस्टर'] },
    ];
  }

  function getNavigationTarget(input, context, matchedCourses) {
    if (Array.isArray(matchedCourses) && matchedCourses.length && matchedCourses[0].url) {
      return {
        label: matchedCourses[0].title,
        href: matchedCourses[0].url,
      };
    }

    const targets = buildNavigationTargets(context);

    return targets.find(function (target) {
      return target.href && containsAny(input, target.terms);
    }) || null;
  }

  function getPublicPageActions(context) {
    return buildNavigationTargets(context)
      .filter(function (target) {
        return !!target.href;
      })
      .map(function (target) {
        return {
          label: target.label,
          type: 'link',
          href: target.href,
        };
      });
  }

  function summarizeCourses(list) {
    if (!list || !list.length) {
      return t('summaryCatalog');
    }
    return list.slice(0, 3).map(function (item) {
      return item.title;
    }).join(', ');
  }

  function summarizeWorkshopDetails(list) {
    if (!Array.isArray(list) || !list.length) {
      return '';
    }

    return list.slice(0, 3).map(function (item) {
      if (!item || !item.title) {
        return '';
      }

      const bits = [item.title];
      if (item.date) {
        bits.push('on ' + item.date);
      }
      if (item.time) {
        bits.push('at ' + item.time);
      }
      if (item.venue) {
        bits.push('(' + item.venue + ')');
      }
      return bits.join(' ');
    }).filter(Boolean).join(' | ');
  }

  function isMentorshipBookingIntent(input) {
    return containsAny(input, INTENTS.mentorship) && containsAny(input, INTENTS.booking);
  }

  function normalizeMentorshipInput(rawMessage) {
    const devanagariDigits = {
      '\u0966': '0',
      '\u0967': '1',
      '\u0968': '2',
      '\u0969': '3',
      '\u096A': '4',
      '\u096B': '5',
      '\u096C': '6',
      '\u096D': '7',
      '\u096E': '8',
      '\u096F': '9',
    };

    let source = normalizeText(rawMessage).toLowerCase();
    source = source.replace(/[\u0966-\u096F]/g, function (digit) {
      return devanagariDigits[digit] || digit;
    });

    source = source
      .replace(/a\s*\.?\s*m\s*\.?/gi, 'am')
      .replace(/p\s*\.?\s*m\s*\.?/gi, 'pm')
      .replace(/(^|\s)\u0938\u0941\u092c\u0939(?=\s|$)/gi, '$1am ')
      .replace(/(^|\s)\u0936\u093e\u092e(?=\s|$)/gi, '$1pm ')
      .replace(/(^|\s)\u0926\u094b\u092a\u0939\u0930(?=\s|$)/gi, '$1pm ')
      .replace(/(^|\s)\u0930\u093e\u0924(?=\s|$)/gi, '$1pm ')
      .replace(/\bbaje\b/gi, ' ')
      .replace(/(^|\s)\u092c\u091c\u0947(?=\s|$)/gi, ' ')
      .replace(/[–—]/g, '-')
      .replace(/\u091f\u0942/g, ' to ')
      .replace(/\u0924\u0941/g, ' to ')
      .replace(/\btoo\b/g, ' to ')
      .replace(/\u0924\u0915/g, ' to ')
      .replace(/\buntil\b/g, ' to ')
      .replace(/\btill\b/g, ' to ')
      .replace(/\u0938\u0947/g, ' ')
      .replace(/\bfrom\b/g, ' ')
      .replace(/\bat\b/g, ' ')
      .replace(/\baround\b/g, ' ')
      .replace(/\bslot\b/g, ' ')
      .replace(/\btime\b/g, ' ')
      .replace(/\u0938\u092e\u092f/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();

    return source;
  }

  function resolveUpcomingDateForDay(day) {
    if (!day || day < 1 || day > 31) {
      return null;
    }

    const today = new Date();
    const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    let cursorYear = today.getFullYear();
    let cursorMonth = today.getMonth() + 1;

    for (let i = 0; i < 15; i += 1) {
      const candidate = normalizeDateParts(cursorYear, cursorMonth, day);
      if (candidate && candidate.date >= todayStart) {
        return candidate;
      }

      cursorMonth += 1;
      if (cursorMonth > 12) {
        cursorMonth = 1;
        cursorYear += 1;
      }
    }

    return null;
  }

  function parseMentorshipDate(rawMessage) {
    const rawSource = String(rawMessage || '');
    const source = normalizeMentorshipInput(rawSource);
    let match = source.match(/\b(20\d{2})[\/-](\d{1,2})[\/-](\d{1,2})\b/);
    if (match) {
      return normalizeDateParts(Number(match[1]), Number(match[2]), Number(match[3]));
    }

    match = source.match(/\b(\d{1,2})[\/-](\d{1,2})[\/-](\d{2,4})\b/);
    if (match) {
      const year = Number(match[3].length === 2 ? '20' + match[3] : match[3]);
      return normalizeDateParts(year, Number(match[2]), Number(match[1]));
    }

    const monthMap = {
      jan: 1, january: 1, feb: 2, february: 2, mar: 3, march: 3, apr: 4, april: 4, may: 5, jun: 6, june: 6,
      jul: 7, july: 7, aug: 8, august: 8, sep: 9, sept: 9, september: 9, oct: 10, october: 10, nov: 11, november: 11, dec: 12, december: 12,
      janvari: 1, farvari: 2, marchh: 3, aprail: 4, mayi: 5, mai: 5, junee: 6, julai: 7, agast: 8, sitambar: 9, aktubar: 10, navambar: 11, disambar: 12,
      '\u091c\u0928\u0935\u0930\u0940': 1,
      '\u092b\u0930\u0935\u0930\u0940': 2,
      '\u092e\u093e\u0930\u094d\u091a': 3,
      '\u0905\u092a\u094d\u0930\u0948\u0932': 4,
      '\u092e\u0908': 5,
      '\u091c\u0942\u0928': 6,
      '\u091c\u0941\u0932\u093e\u0908': 7,
      '\u0905\u0917\u0938\u094d\u0924': 8,
      '\u0938\u093f\u0924\u0902\u092c\u0930': 9,
      '\u0905\u0915\u094d\u091f\u0942\u092c\u0930': 10,
      '\u0928\u0935\u0902\u092c\u0930': 11,
      '\u0926\u093f\u0938\u0902\u092c\u0930': 12
    };

    match = source.match(/\b(\d{1,2})(?:st|nd|rd|th)?\s+([a-zA-Z\u0900-\u097F]+)\s*(20\d{2})?\b/);
    if (match) {
      const month = monthMap[String(match[2] || '').toLowerCase()];
      let year = match[3] ? Number(match[3]) : (new Date()).getFullYear();
      if (month) {
        let parsed = normalizeDateParts(year, month, Number(match[1]));
        if (!match[3] && parsed) {
          const today = new Date();
          const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
          if (parsed.date < todayStart) {
            year += 1;
            parsed = normalizeDateParts(year, month, Number(match[1]));
          }
        }
        return parsed;
      }
    }

    match = source.match(/\b([a-zA-Z\u0900-\u097F]+)\s+(\d{1,2})(?:st|nd|rd|th)?\s*(20\d{2})?\b/);
    if (match) {
      const month = monthMap[String(match[1] || '').toLowerCase()];
      let year = match[3] ? Number(match[3]) : (new Date()).getFullYear();
      if (month) {
        let parsed = normalizeDateParts(year, month, Number(match[2]));
        if (!match[3] && parsed) {
          const today = new Date();
          const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
          if (parsed.date < todayStart) {
            year += 1;
            parsed = normalizeDateParts(year, month, Number(match[2]));
          }
        }
        return parsed;
      }
    }

    // Hindi/voice phrasing support like "1 में 10:00 a.m टू 10:30 a.m"
    match = rawSource.toLowerCase().match(/(?:^|\s)(\d{1,2})\s*(?:\u092e\u0947\u0902|\u092e\u0947|\u0915\u094b|ko)(?=\s+\d{1,2}(?::[0-5]\d)?)/i);
    if (match) {
      const inferred = resolveUpcomingDateForDay(Number(match[1]));
      if (inferred) {
        return inferred;
      }
    }

    // Day-only fallback when users share "1 10:00 AM to 10:30 AM".
    match = source.match(/(?:^|\s)(\d{1,2})(?=\s+\d{1,2}(?::[0-5]\d)?\s*(?:am|pm)?)/i);
    if (match) {
      const inferred = resolveUpcomingDateForDay(Number(match[1]));
      if (inferred) {
        return inferred;
      }
    }

    return null;
  }

  function normalizeDateParts(year, month, day) {
    if (!year || !month || !day) {
      return null;
    }

    const candidate = new Date(year, month - 1, day);
    if (
      candidate.getFullYear() !== year ||
      candidate.getMonth() !== month - 1 ||
      candidate.getDate() !== day
    ) {
      return null;
    }

    return {
      year: year,
      month: month,
      day: day,
      iso: [year, String(month).padStart(2, '0'), String(day).padStart(2, '0')].join('-'),
      label: candidate.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }),
      date: candidate,
    };
  }

  function parseTimeToken(token, inheritedMeridiem) {
    const raw = normalizeText(token).toLowerCase();
    const match = raw.match(/^([01]?\d|2[0-3])(?::([0-5]\d))?\s*(am|pm)?$/i);
    if (!match) {
      return null;
    }

    let hour = Number(match[1]);
    const minute = Number(match[2] || 0);
    const meridiem = (match[3] || inheritedMeridiem || '').toLowerCase();

    if (meridiem === 'am' || meridiem === 'pm') {
      if (hour === 12) {
        hour = meridiem === 'am' ? 0 : 12;
      } else if (meridiem === 'pm') {
        hour += 12;
      }
    } else if (hour >= 2 && hour <= 5) {
      hour += 12;
    }

    return (hour * 60) + minute;
  }

  function parseMentorshipTimeWindow(rawMessage) {
    const source = normalizeMentorshipInput(rawMessage);
    const rangeMatch = source.match(/\b([01]?\d(?::[0-5]\d)?\s*(?:am|pm)?)\s*(?:to|-|until|till)\s*([01]?\d(?::[0-5]\d)?\s*(?:am|pm)?)\b/i);

    if (rangeMatch) {
      const leftMeridiem = /\b(am|pm)\b/i.test(rangeMatch[1]) ? rangeMatch[1].match(/\b(am|pm)\b/i)[1].toLowerCase() : '';
      const rightMeridiem = /\b(am|pm)\b/i.test(rangeMatch[2]) ? rangeMatch[2].match(/\b(am|pm)\b/i)[1].toLowerCase() : '';
      const start = parseTimeToken(rangeMatch[1], rightMeridiem);
      const end = parseTimeToken(rangeMatch[2], leftMeridiem);
      if (start === null || end === null) {
        return null;
      }
      return { start: start, end: end };
    }

    const singleMatch =
      source.match(/\b(?:at|around|from|slot|time)\s*([01]?\d(?::[0-5]\d)?\s*(?:am|pm)?)\b/i) ||
      source.match(/\b([01]?\d:[0-5]\d\s*(?:am|pm)?)\b/i) ||
      source.match(/\b([01]?\d\s*(?:am|pm))\b/i);
    if (!singleMatch) {
      return null;
    }

    const start = parseTimeToken(singleMatch[1], '');
    if (start === null) {
      return null;
    }

    return { start: start, end: start + 30 };
  }

  function formatTimeLabel(minutes) {
    const hour24 = Math.floor(minutes / 60);
    const minute = minutes % 60;
    const meridiem = hour24 >= 12 ? 'PM' : 'AM';
    let hour12 = hour24 % 12;
    if (hour12 === 0) {
      hour12 = 12;
    }
    return String(hour12) + ':' + String(minute).padStart(2, '0') + ' ' + meridiem;
  }

  function getMentorshipSlotValidation(start, end) {
    if (end <= start) {
      return { ok: false, code: 'duration' };
    }
    if ((start % 30) !== 0 || (end % 30) !== 0) {
      return { ok: false, code: 'step' };
    }
    if ((end - start) !== 30) {
      return { ok: false, code: 'duration' };
    }

    const morningWindow = start >= 600 && end <= 720;
    const afternoonWindow = start >= 840 && end <= 1020;
    if (!morningWindow && !afternoonWindow) {
      return { ok: false, code: 'window' };
    }

    return { ok: true, window: morningWindow ? '10:00 AM - 12:00 PM' : '2:00 PM - 5:00 PM' };
  }

  function parseMentorshipBooking(rawMessage) {
    const dateInfo = parseMentorshipDate(rawMessage);
    const timeInfo = parseMentorshipTimeWindow(rawMessage);

    if (!dateInfo && !timeInfo) {
      return { ok: false, code: 'missing_date_time' };
    }
    if (!dateInfo) {
      return { ok: false, code: 'missing_date' };
    }
    if (!timeInfo) {
      return { ok: false, code: 'missing_time', date: dateInfo.label };
    }

    const today = new Date();
    const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    if (dateInfo.date < todayStart) {
      return { ok: false, code: 'past_date' };
    }

    const slotValidation = getMentorshipSlotValidation(timeInfo.start, timeInfo.end);
    if (!slotValidation.ok) {
      return { ok: false, code: slotValidation.code, date: dateInfo.label };
    }

    return {
      ok: true,
      dateIso: dateInfo.iso,
      dateLabel: dateInfo.label,
      startMinutes: timeInfo.start,
      endMinutes: timeInfo.end,
      startLabel: formatTimeLabel(timeInfo.start),
      endLabel: formatTimeLabel(timeInfo.end),
      slotLabel: formatTimeLabel(timeInfo.start) + ' to ' + formatTimeLabel(timeInfo.end),
      windowLabel: slotValidation.window,
    };
  }

  function generateMentorshipBookingId() {
    const now = new Date();
    const stamp = [
      now.getFullYear(),
      String(now.getMonth() + 1).padStart(2, '0'),
      String(now.getDate()).padStart(2, '0'),
    ].join('');
    const random = Math.random().toString(36).slice(2, 6).toUpperCase();
    return 'MENT-' + stamp + '-' + random;
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
      return t('subjectMentorship', { interest: interest });
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
    const normalizedMessage = String(message || '').toLowerCase();
    const matchedCourse = Array.isArray(matchedCourses) && matchedCourses.length ? matchedCourses[0] : null;

    if (matchedCourse) {
      details.courseId = matchedCourse.id || null;
      details.courseInterest = matchedCourse.title || null;
    }

    if (context && Array.isArray(context.workshops)) {
      const workshopMatch = context.workshops.find(function (item) {
        return item && item.title && normalizedMessage.indexOf(String(item.title).toLowerCase()) !== -1;
      });
      if (workshopMatch) {
        if (!details.courseInterest) {
          details.courseInterest = workshopMatch.title;
        }
        details.workshopLookup = 'matched';
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
    Array.prototype.forEach.call(temp.querySelectorAll('br'), function (node) {
      node.replaceWith(document.createTextNode(' '));
    });
    Array.prototype.forEach.call(temp.querySelectorAll('p, li, div'), function (node) {
      node.appendChild(document.createTextNode(' '));
    });
    return (temp.textContent || temp.innerText || '').trim();
  }

  function humanizeSpeechText(html) {
    return plainTextFromHtml(html)
      .replace(/\s*\|\s*/g, '. ')
      .replace(/\bPrice:/gi, 'Price is')
      .replace(/\bLevel:/gi, 'Level is')
      .replace(/\bDuration:/gi, 'Duration is')
      .replace(/\bLanguage:/gi, 'Language is')
      .replace(/\bCampus:/gi, 'Campus is')
      .replace(/\bSchedule:/gi, 'Schedule is')
      .replace(/\bFor:/gi, 'For')
      .replace(/\bफीस:/g, 'फीस है')
      .replace(/\bलेवल:/g, 'लेवल है')
      .replace(/\bअवधि:/g, 'अवधि है')
      .replace(/\bभाषा:/g, 'भाषा है')
      .replace(/\bकैंपस:/g, 'कैंपस है')
      .replace(/\bशेड्यूल:/g, 'शेड्यूल है')
      .replace(/\s+/g, ' ')
      .trim();
  }

  function detectSpeechLanguage(text) {
    const source = String(text || '');
    if (/[\u0900-\u097F]/.test(source)) {
      return 'hi';
    }

    if (/[a-z]/i.test(source)) {
      return 'en';
    }

    return state.language === 'hi' ? 'hi' : 'en';
  }

  function selectPreferredVoice() {
    if (!('speechSynthesis' in window) || typeof window.speechSynthesis.getVoices !== 'function') {
      state.preferredVoices = { en: null, hi: null };
      state.preferredVoice = null;
      return;
    }

    const voices = window.speechSynthesis.getVoices();
    if (!Array.isArray(voices) || !voices.length) {
      state.preferredVoices = { en: null, hi: null };
      state.preferredVoice = null;
      return;
    }

    const femaleHints = [
      'female', 'woman', 'girl', 'zira', 'aria', 'samantha', 'victoria', 'karen',
      'natasha', 'veena', 'moira', 'serena', 'susan', 'hazel', 'allison', 'ava',
      'jenny', 'sonia', 'neerja', 'priya', 'raveena', 'heera', 'swara', 'aditi',
      'kalpana'
    ];

    const qualityHints = ['google', 'microsoft', 'neural', 'natural', 'online', 'enhanced', 'premium', 'studio'];
    const englishPersonaPriority = [
      'microsoft heera', 'heera', 'microsoft ravi', 'ravi',
      'microsoft neerja', 'neerja', 'microsoft priya', 'priya',
      'google indian english', 'google english india', 'english india',
      'en-in', 'india'
    ];
    const generalEnglishPriority = ['samantha', 'aria', 'jenny', 'sonia', 'ava', 'google uk english female', 'google us english'];
    const hindiPriority = ['google हिन्दी', 'google hindi', 'swara', 'heera', 'priya', 'neerja', 'kalpana', 'hindi'];

    function scoreVoice(voice, targetLanguage) {
      const haystack = [
        voice.name || '',
        voice.voiceURI || '',
        voice.lang || ''
      ].join(' ').toLowerCase();

      let score = 0;

      if (targetLanguage === 'hi') {
        if (/^hi(-|_)?in/i.test(voice.lang || '')) {
          score += 84;
        } else if (/^hi/i.test(voice.lang || '')) {
          score += 70;
        } else if (/^en(-|_)?in/i.test(voice.lang || '')) {
          score += 12;
        } else {
          score -= 20;
        }

        hindiPriority.forEach(function (hint, index) {
          if (haystack.indexOf(hint) !== -1) {
            score += 44 - (index * 3);
          }
        });
      } else {
        if (/^en(-|_)?in/i.test(voice.lang || '')) {
          score += 78;
        } else if (/^en(-|_)?(us|gb|au)/i.test(voice.lang || '')) {
          score += 24;
        } else if (/^en/i.test(voice.lang || '')) {
          score += 16;
        } else if (/^hi(-|_)?in/i.test(voice.lang || '')) {
          score += 10;
        }

        englishPersonaPriority.forEach(function (hint, index) {
          if (haystack.indexOf(hint) !== -1) {
            score += 54 - (index * 3);
          }
        });

        generalEnglishPriority.forEach(function (hint, index) {
          if (haystack.indexOf(hint) !== -1) {
            score += 18 - (index * 2);
          }
        });
      }

      if (femaleHints.some(function (hint) { return haystack.indexOf(hint) !== -1; })) {
        score += 14;
      }

      if (qualityHints.some(function (hint) { return haystack.indexOf(hint) !== -1; })) {
        score += 8;
      }

      if (voice.default) {
        score += 2;
      }

      return score;
    }

    function pickVoice(targetLanguage) {
      let candidates = voices;
      if (targetLanguage === 'hi') {
        const hindiCandidates = voices.filter(function (voice) {
          const haystack = [voice.name || '', voice.voiceURI || '', voice.lang || ''].join(' ').toLowerCase();
          return /^hi/i.test(voice.lang || '') || haystack.indexOf('hindi') !== -1 || haystack.indexOf('हिन्दी') !== -1;
        });

        if (!hindiCandidates.length) {
          return null;
        }

        candidates = hindiCandidates;
      }

      const scoredVoices = candidates.map(function (voice) {
        return {
          voice: voice,
          score: scoreVoice(voice, targetLanguage),
        };
      }).sort(function (a, b) {
        return b.score - a.score;
      });

      return scoredVoices.length ? scoredVoices[0].voice : null;
    }

    const hindiVoice = pickVoice('hi');
    const englishVoice = pickVoice('en');

    state.preferredVoices = {
      en: hindiVoice || englishVoice,
      hi: hindiVoice,
      fallbackEn: englishVoice,
    };
    state.preferredVoice = state.preferredVoices[state.language] || state.preferredVoices.en || state.preferredVoices.hi || null;
  }

  function resolveVoiceForText(text) {
    const preferredLanguage = state.language === 'hi' ? 'hi' : detectSpeechLanguage(text);
    let selectedVoice = null;

    if (preferredLanguage === 'hi') {
      selectedVoice = state.preferredVoices.hi || null;
    } else {
      selectedVoice =
        state.preferredVoices.en ||
        state.preferredVoice ||
        null;
    }

    const resolvedLang = selectedVoice && selectedVoice.lang
      ? selectedVoice.lang
      : (preferredLanguage === 'hi' ? 'hi-IN' : 'en-IN');

    return {
      voice: selectedVoice,
      language: preferredLanguage,
      langCode: resolvedLang,
    };
  }

  function stopSpeechPlayback() {
    state.speechJobId += 1;
    if (state.speechRetryTimer) {
      window.clearTimeout(state.speechRetryTimer);
      state.speechRetryTimer = null;
    }

    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
    }
  }

  function speak(html) {
    state.speechEnabled = 'speechSynthesis' in window;
    if (!state.autoSpeak || !state.speechEnabled) {
      return;
    }

    const text = humanizeSpeechText(html);
    if (!text) {
      return;
    }

    stopSpeechPlayback();
    const speechJobId = state.speechJobId;
    speakTextWithRetry(text, 0, speechJobId);
  }

  function speakTextWithRetry(text, attempt, speechJobId) {
    if (state.speechRetryTimer) {
      window.clearTimeout(state.speechRetryTimer);
      state.speechRetryTimer = null;
    }

    state.speechRetryTimer = window.setTimeout(function () {
      state.speechRetryTimer = null;
      if (speechJobId !== state.speechJobId || !state.autoSpeak || !state.speechEnabled) {
        return;
      }

      if (typeof window.speechSynthesis.getVoices === 'function') {
        selectPreferredVoice();
      }

      const attempts = buildSpeechAttempts(text);
      const speechAttempt = attempts[attempt] || null;
      if (!speechAttempt) {
        setHint(state.language === 'hi'
          ? 'आवाज शुरू नहीं हो पाई। कृपया ब्राउज़र में Hindi/English voice enabled रखें और फिर volume पर टैप करें।'
          : 'Voice could not start. Please enable browser voices and tap volume again.',
          'error');
        return;
      }

      const utterance = new SpeechSynthesisUtterance(text);
      let didStart = false;
      utterance.lang = speechAttempt.langCode;
      utterance.rate = 0.88;
      utterance.pitch = 1.0;
      utterance.volume = 1;

      if (speechAttempt.voice) {
        utterance.voice = speechAttempt.voice;
      }

      if (window.speechSynthesis.paused) {
        window.speechSynthesis.resume();
      }

      utterance.onstart = function () {
        didStart = true;
      };

      utterance.onend = function () {
        if (speechJobId === state.speechJobId) {
          state.speechRetryTimer = null;
        }
      };

      utterance.onerror = function (event) {
        const errorName = event && event.error ? String(event.error) : '';
        if (speechJobId !== state.speechJobId || didStart || errorName === 'canceled' || errorName === 'interrupted') {
          return;
        }

        if (state.autoSpeak) {
          speakTextWithRetry(text, attempt + 1, speechJobId);
        }
      };

      try {
        window.speechSynthesis.speak(utterance);
      } catch (error) {
        if (speechJobId === state.speechJobId) {
          speakTextWithRetry(text, attempt + 1, speechJobId);
        }
      }
    }, attempt === 0 ? 80 : 240);
  }

  function buildSpeechAttempts(text) {
    const preferredLanguage = state.language === 'hi' ? 'hi' : detectSpeechLanguage(text);
    const hindiVoice = state.preferredVoices.hi || null;
    const englishVoice = state.preferredVoices.fallbackEn ||
      (state.preferredVoices.en && state.preferredVoices.en !== hindiVoice ? state.preferredVoices.en : null) ||
      null;
    const attempts = [];

    function addAttempt(voice, langCode, language) {
      const key = [
        voice ? (voice.voiceURI || voice.name || voice.lang || 'voice') : 'browser-default',
        langCode,
        language
      ].join('|');

      if (attempts.some(function (item) { return item.key === key; })) {
        return;
      }

      attempts.push({
        key: key,
        voice: voice,
        langCode: langCode,
        language: language,
      });
    }

    if (preferredLanguage === 'hi') {
      addAttempt(hindiVoice, hindiVoice && hindiVoice.lang ? hindiVoice.lang : 'hi-IN', 'hi');
      addAttempt(null, 'hi-IN', 'hi');
      if (englishVoice) {
        addAttempt(englishVoice, 'hi-IN', 'hi');
      }

      return attempts;
    }

    if (hindiVoice) {
      addAttempt(hindiVoice, hindiVoice.lang || 'hi-IN', 'en');
      addAttempt(hindiVoice, 'en-IN', 'en');
    }

    if (englishVoice) {
      addAttempt(englishVoice, englishVoice.lang || 'en-IN', 'en');
    }

    addAttempt(null, 'en-IN', 'en');

    return attempts;
  }

  function primeSpeechSynthesis() {
    state.speechEnabled = 'speechSynthesis' in window;
    if (!state.autoSpeak || !state.speechEnabled || state.speechPrimed) {
      return;
    }

    try {
      const unlockUtterance = new SpeechSynthesisUtterance('.');
      unlockUtterance.volume = 0;
      unlockUtterance.lang = state.language === 'hi' ? 'hi-IN' : 'en-IN';
      window.speechSynthesis.resume();
      window.speechSynthesis.speak(unlockUtterance);
      state.speechPrimed = true;
    } catch (error) {
      state.speechPrimed = false;
    }
  }

  function getLastBotMessageHtml() {
    const botMessages = elements.messages.querySelectorAll('.cyi-chatbot__message--bot .cyi-chatbot__bubble');
    if (!botMessages.length) {
      return '';
    }

    return botMessages[botMessages.length - 1].innerHTML || '';
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
    if (state.voiceSilenceTimer) {
      window.clearTimeout(state.voiceSilenceTimer);
      state.voiceSilenceTimer = null;
    }
    state.isProcessingVoice = false;
    state.shouldSubmitVoiceOnEnd = false;
    state.voiceBaseText = '';
    state.recognitionFinalText = '';
    state.recognitionInterimText = '';
    state.recognitionHadResult = false;
    state.lastRecognitionError = '';
  }

  function clearVoiceSilenceTimer() {
    if (!state.voiceSilenceTimer) {
      return;
    }

    window.clearTimeout(state.voiceSilenceTimer);
    state.voiceSilenceTimer = null;
  }

  function finalizeVoiceCapture() {
    if (!state.isListening || !state.recognition) {
      return;
    }

    clearVoiceSilenceTimer();
    state.isProcessingVoice = true;
    updateMicButton();
    setHint(t('hintVoiceFinishing'), 'active');

    try {
      state.recognition.stop();
    } catch (error) {
      // Ignore stop timing issues.
    }
  }

  function scheduleVoiceAutoStop() {
    if (!state.shouldSubmitVoiceOnEnd || !state.isListening || !state.recognitionHadResult) {
      return;
    }

    clearVoiceSilenceTimer();
    state.voiceSilenceTimer = window.setTimeout(function () {
      finalizeVoiceCapture();
    }, VOICE_AUTO_SEND_SILENCE_MS);
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
      clearVoiceSilenceTimer();
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
      scheduleVoiceAutoStop();
      setHint(state.recognitionInterimText ? t('hintListeningContinue') : t('hintVoiceFinishingCaptured'), 'active');
    };

    recognition.onspeechend = function () {
      if (!state.isListening) {
        return;
      }

      scheduleVoiceAutoStop();
    };

    recognition.onerror = function (event) {
      state.lastRecognitionError = event && event.error ? event.error : 'error';
      clearVoiceSilenceTimer();
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
      clearVoiceSilenceTimer();
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
    const wantsAllPublicPages = containsAny(input, [
      'all public pages',
      'all pages',
      'public pages',
      'home pages',
      'website pages',
      'all home pages',
      'सभी पब्लिक पेज',
      'सभी पेज',
      'होम पेज',
      'पब्लिक पेज'
    ]);
    const navigationTarget = detectNavigationRequest(input) ? getNavigationTarget(input, context, matchedCourses) : null;

    if (wantsAllPublicPages) {
      return {
        html: paragraphs([
          t('replyPublicPages1'),
          t('replyPublicPages2')
        ]),
        actions: getPublicPageActions(context)
      };
    }

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

    if (isMentorshipBookingIntent(input) || state.awaitingMentorshipSchedule) {
      const booking = parseMentorshipBooking(rawMessage);
      if (!booking.ok) {
        state.awaitingMentorshipSchedule = true;
        if (booking.code === 'missing_date_time') {
          return {
            html: paragraphs([
              t('replyMentorshipBookingAskDate'),
              t('replyMentorshipBookingRules'),
              t('replyMentorshipBookingExamples')
            ]),
            actions: [
              { label: t('buttonShowSlots'), type: 'prompt', prompt: 'Show mentorship slot rules for booking' }
            ]
          };
        }

        if (booking.code === 'missing_date') {
          return {
            html: paragraphs([
              t('replyMentorshipBookingAskDateOnly'),
              t('replyMentorshipBookingRules')
            ])
          };
        }

        if (booking.code === 'missing_time') {
          return {
            html: paragraphs([
              t('replyMentorshipBookingAskTime', { date: escapeHtml(booking.date || '') }),
              t('replyMentorshipBookingExamples')
            ])
          };
        }

        if (booking.code === 'past_date') {
          return {
            html: paragraphs([
              t('replyMentorshipBookingInvalidPastDate'),
              t('replyMentorshipBookingRules')
            ])
          };
        }

        const invalidKey = booking.code === 'duration'
          ? 'replyMentorshipBookingInvalidDuration'
          : booking.code === 'step'
            ? 'replyMentorshipBookingInvalidStep'
            : 'replyMentorshipBookingInvalidSlot';

        return {
          html: paragraphs([
            t(invalidKey),
            t('replyMentorshipBookingRules'),
            t('replyMentorshipBookingExamples')
          ])
        };
      }

      state.awaitingMentorshipSchedule = false;
      const bookingId = generateMentorshipBookingId();
      const userName = (state.profile && state.profile.name) ? state.profile.name : 'User';
      const bookingDetails = {
        courseInterest: 'Mentorship Slot ' + booking.dateLabel + ' ' + booking.slotLabel,
        bookingId: bookingId,
        mentorshipDate: booking.dateIso,
        mentorshipStartTime: booking.startLabel,
        mentorshipEndTime: booking.endLabel,
        mentorshipSlotLabel: booking.slotLabel,
        mentorshipDurationMinutes: 30,
        requestedScheduleWindow: booking.windowLabel,
      };

      return {
        html: paragraphs([
          t('replyMentorshipBookingConfirmed1'),
          t('replyMentorshipBookingConfirmedUser', { name: escapeHtml(userName) }),
          t('replyMentorshipBookingConfirmed2', { bookingId: escapeHtml(bookingId) }),
          t('replyMentorshipBookingConfirmed3', { date: escapeHtml(booking.dateLabel), slot: escapeHtml(booking.slotLabel) })
        ]),
        actions: [
          {
            label: t('buttonMentorshipBookingRequest'),
            type: 'lead',
            topic: 'mentorship',
            subject: buildLeadSubject('mentorship', bookingDetails),
            courseInterest: bookingDetails.courseInterest,
            bookingId: bookingDetails.bookingId,
            mentorshipDate: bookingDetails.mentorshipDate,
            mentorshipStartTime: bookingDetails.mentorshipStartTime,
            mentorshipEndTime: bookingDetails.mentorshipEndTime,
            mentorshipSlotLabel: bookingDetails.mentorshipSlotLabel,
            mentorshipDurationMinutes: bookingDetails.mentorshipDurationMinutes,
            requestedScheduleWindow: bookingDetails.requestedScheduleWindow,
            message: 'I booked the free mentorship for ' + userName + ' on ' + booking.dateLabel + ' at ' + booking.slotLabel + '. Booking ID: ' + bookingId + '.',
            autoSubmit: true,
            suppressSuccessMessage: true,
          }
        ],
        autoLeadAction: {
          type: 'lead',
          topic: 'mentorship',
          subject: buildLeadSubject('mentorship', bookingDetails),
          courseInterest: bookingDetails.courseInterest,
          bookingId: bookingDetails.bookingId,
          mentorshipDate: bookingDetails.mentorshipDate,
          mentorshipStartTime: bookingDetails.mentorshipStartTime,
          mentorshipEndTime: bookingDetails.mentorshipEndTime,
          mentorshipSlotLabel: bookingDetails.mentorshipSlotLabel,
          mentorshipDurationMinutes: bookingDetails.mentorshipDurationMinutes,
          requestedScheduleWindow: bookingDetails.requestedScheduleWindow,
          message: 'I booked the free mentorship for ' + userName + ' on ' + booking.dateLabel + ' at ' + booking.slotLabel + '. Booking ID: ' + bookingId + '.',
          suppressSuccessMessage: true,
        }
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
            workshopLookup: details.workshopLookup || null,
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
      const workshopDetails = summarizeWorkshopDetails(context.workshops);
      const hasWorkshopListings = Array.isArray(context.workshops) && context.workshops.length > 0;
      return {
        html: paragraphs([
          t('replyWorkshop1'),
          hasWorkshopListings
            ? t('replyWorkshop2', { items: escapeHtml(workshopDetails) })
            : t('replyWorkshopNone')
        ]),
        actions: [
          context.routes.workshop ? { label: t('buttonOpenWorkshopPage'), type: 'link', href: context.routes.workshop } : null,
          { label: t('buttonWorkshopInquiry'), type: 'lead', topic: 'workshop', subject: buildLeadSubject('workshop', { courseInterest: hasWorkshopListings ? 'Available workshop details requested' : '' }), message: rawMessage, workshopLookup: hasWorkshopListings ? 'available_listed' : 'no_active_workshop' }
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

  function shouldUseLocalResponse(message) {
    const input = String(message || '').toLowerCase();
    return state.awaitingMentorshipSchedule || isMentorshipBookingIntent(input);
  }

  function postChatMessage(message) {
    if (!config.messageUrl || shouldUseLocalResponse(message)) {
      return Promise.resolve(buildResponse(message));
    }

    return fetch(config.messageUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': config.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        message: message,
        language: state.language,
        history: (state.history || []).slice(-8).map(function (entry) {
          return {
            role: entry.role,
            html: entry.html
          };
        })
      })
    }).then(function (response) {
      return response.json().catch(function () {
        return {};
      }).then(function (data) {
        if (!response.ok || !data || !data.html) {
          throw new Error(data.message || data.error || 'Model reply unavailable');
        }
        return data;
      });
    }).catch(function () {
      return buildResponse(message);
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
      booking_id: action.bookingId || null,
      mentorship_date: action.mentorshipDate || null,
      mentorship_start_time: action.mentorshipStartTime || null,
      mentorship_end_time: action.mentorshipEndTime || null,
      mentorship_slot_label: action.mentorshipSlotLabel || null,
      mentorship_duration_minutes: action.mentorshipDurationMinutes || null,
      requested_schedule_window: action.requestedScheduleWindow || null,
      workshop_lookup: action.workshopLookup || null,
      page_url: window.location.pathname + window.location.search,
      source_page: 'chatbot-widget',
      language: state.language,
    }).then(function (payload) {
      removeTyping(typingNode);
      if (action.suppressSuccessMessage) {
        return;
      }

      const inquiryId = payload && payload.contact_id ? String(payload.contact_id) : '';
      const lines = [t('inquirySuccess')];
      if (inquiryId) {
        lines.push(t('inquirySuccessWithId', { id: escapeHtml(inquiryId) }));
      }
      lines.push(t('inquirySuccessTeam'));
      addMessage('bot', paragraphs(lines));
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
    primeSpeechSynthesis();
    const typingNode = addTyping();

    window.setTimeout(function () {
      postChatMessage(message).then(function (response) {
        removeTyping(typingNode);
        addMessage('bot', response.html, response.actions || []);
        if (response.autoLeadAction && state.profile) {
          submitInquiryAction(response.autoLeadAction);
        }
        if (response.navigateTo) {
          window.setTimeout(function () {
            window.location.href = response.navigateTo;
          }, 700);
        }
      });
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
    state.awaitingMentorshipSchedule = false;
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
    saveAutoSpeak(state.autoSpeak);
    updateSpeakButton();
    if (!state.autoSpeak) {
      stopSpeechPlayback();
      return;
    }

    const lastBotHtml = getLastBotMessageHtml();
    if (lastBotHtml) {
      primeSpeechSynthesis();
      speak(lastBotHtml);
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
      finalizeVoiceCapture();
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
