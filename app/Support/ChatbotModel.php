<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ChatbotModel
{
    private string $language = 'en';

    private const INTENT_MODEL = [
        'training' => [
            'training program course admission fees fee price pricing syllabus curriculum learn learning online class',
            'which course should i join data science full stack digital marketing cyber security power bi',
            'कोर्स कोर्सेस ट्रेनिंग प्रोग्राम एडमिशन फीस प्राइस',
        ],
        'mentorship' => [
            'mentorship mentor roadmap guidance career roadmap counselling free mentorship',
            'need guidance mentor me career planning learning path',
            'मेंटरशिप मेंटोर रोडमैप मार्गदर्शन',
        ],
        'workshop' => [
            'workshop bootcamp webinar event upcoming workshop schedule time',
            'available workshops workshop details workshop timing',
            'वर्कशॉप बूटकैंप',
        ],
        'placement' => [
            'placement placements job jobs interview resume career support hiring internship',
            'placement support job assistance career help',
            'प्लेसमेंट जॉब नौकरी प्लेसमेंट सपोर्ट',
        ],
        'contact' => [
            'contact support human call phone email team talk connect help',
            'talk to team call me get in touch contact me',
            'कॉन्टैक्ट संपर्क सपोर्ट टीम कॉल बात',
        ],
        'offline' => [
            'offline classroom campus center centre in person surat branch',
            'offline course classroom training campus program',
            'ऑफलाइन क्लासरूम कैंपस',
        ],
        'certificate' => [
            'certificate certification completion proof credential verify certificate',
            'will i get certificate after course',
            'सर्टिफिकेट प्रमाणपत्र सर्टिफिकेशन',
        ],
        'auth' => [
            'login register signup sign in sign up account password student portal',
            'create account learner account login page',
            'लॉगिन रजिस्टर साइन इन साइन अप',
        ],
        'navigation' => [
            'go to take me to open redirect navigate show page website homepage public pages',
            'open courses page open contact page show all pages',
            'खोलो ले चलो दिखाओ ओपन भेजो जाना पेज',
        ],
        'greeting' => [
            'hello hi hey namaste good morning good evening',
            'start chatbot help me',
            'नमस्ते हेलो हाय',
        ],
    ];

    public function reply(string $message, array $context, array $options = []): array
    {
        $message = trim($message);
        $language = Arr::get($options, 'language') === 'hi' ? 'hi' : 'en';
        $this->language = $language;
        $classification = $this->classify($message);
        $intent = $classification['intent'];
        $courses = $this->rankCourses($message, $context);

        if ($this->wantsAllPublicPages($message)) {
            return $this->response([
                'Here are the public pages you can open right now.',
                'Tap any page below and I will redirect you.',
            ], $this->publicPageActions($context), $classification, 'navigation');
        }

        if ($intent === 'navigation') {
            $target = $this->navigationTarget($message, $context, $courses);
            if ($target) {
                return $this->response([
                    'Taking you to the <strong>'.$this->e($target['label']).'</strong>.',
                    'Redirecting now.',
                ], [
                    ['label' => 'Open Now', 'type' => 'link', 'href' => $target['href']],
                ], $classification, 'navigation', $target['href']);
            }
        }

        if ($courses !== []) {
            $course = $courses[0];

            return $this->response([
                '<strong>'.$this->e($course['title']).'</strong>',
                $this->e($this->courseSummary($course) ?: 'You can open the training program page for full details.').'.',
            ], $this->courseActions(array_slice($courses, 0, 3), $context), $classification, 'course_match');
        }

        if ($this->wantsLead($message)) {
            $topic = $this->leadTopic($intent);

            return $this->response([
                'I can send this request to the team for you.',
            ], [[
                'label' => 'Send Inquiry',
                'type' => 'lead',
                'topic' => $topic,
                'subject' => $this->leadSubject($topic),
                'message' => $message,
            ]], $classification, 'lead');
        }

        return match ($intent) {
            'certificate' => $this->response([
                'Eligible learners can access certificates after completing their training program requirements.',
                $this->e((string) Arr::get($context, 'quick_answers.certificates', '')),
            ], array_values(array_filter([
                Arr::get($context, 'routes.login') ? ['label' => 'Student Login', 'type' => 'link', 'href' => Arr::get($context, 'routes.login')] : null,
                ['label' => 'Training Programs', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'ट्रेनिंग प्रोग्राम' : 'training programs'],
            ])), $classification),
            'mentorship' => $this->response([
                'Mentorship is available for guidance, planning, and next-step support.',
                'If you want, I can send a mentorship request to the team.',
            ], array_values(array_filter([
                Arr::get($context, 'routes.mentorship') ? ['label' => 'Open Mentorship', 'type' => 'link', 'href' => Arr::get($context, 'routes.mentorship')] : null,
                ['label' => 'Request Mentorship', 'type' => 'lead', 'topic' => 'mentorship', 'subject' => $this->leadSubject('mentorship'), 'message' => $message],
            ])), $classification),
            'workshop' => $this->workshopResponse($message, $context, $classification),
            'placement' => $this->response([
                'This LMS includes placement-focused guidance and career support.',
                $this->e((string) Arr::get($context, 'quick_answers.placement', 'If you want help with that path, I can connect you to the team.')),
            ], array_values(array_filter([
                Arr::get($context, 'routes.placement') ? ['label' => 'Placement Page', 'type' => 'link', 'href' => Arr::get($context, 'routes.placement')] : null,
                ['label' => 'Placement Help', 'type' => 'lead', 'topic' => 'placement', 'subject' => $this->leadSubject('placement'), 'message' => $message],
            ])), $classification),
            'contact' => $this->response([
                'You can contact the team directly at <strong>'.$this->e((string) Arr::get($context, 'brand.email', 'codeinyourself@gmail.com')).'</strong> or <strong>'.$this->e((string) Arr::get($context, 'brand.phone', '+91 90164 27165')).'</strong>.',
            ], array_values(array_filter([
                Arr::get($context, 'routes.contact') ? ['label' => 'Contact Page', 'type' => 'link', 'href' => Arr::get($context, 'routes.contact')] : null,
                ['label' => 'Send Message', 'type' => 'lead', 'topic' => 'support', 'subject' => $this->leadSubject('support'), 'message' => $message],
            ])), $classification),
            'offline' => $this->response([
                'Offline options are available through the training program catalog.',
                'Some current offline choices include '.$this->e($this->listTitles((array) Arr::get($context, 'offline_courses', []))).'.',
            ], $this->courseActions((array) Arr::get($context, 'offline_courses', []), $context, 'Offline Training Programs', Arr::get($context, 'routes.courses') ? Arr::get($context, 'routes.courses').'?mode=offline' : null), $classification),
            'auth' => $this->response([
                'You can log in if you already have an account, or register as a new learner.',
            ], array_values(array_filter([
                Arr::get($context, 'routes.login') ? ['label' => 'Login', 'type' => 'link', 'href' => Arr::get($context, 'routes.login')] : null,
                Arr::get($context, 'routes.register') ? ['label' => 'Register', 'type' => 'link', 'href' => Arr::get($context, 'routes.register')] : null,
            ])), $classification),
            'training' => $this->response([
                'You can explore training programs from the catalog.',
                'Some current options include '.$this->e($this->listTitles($this->allCourses($context))).'.',
            ], array_merge(
                $this->courseActions(array_slice($this->allCourses($context), 0, 3), $context, 'Browse Training Programs', Arr::get($context, 'routes.courses')),
                [['label' => 'Training Program Guidance', 'type' => 'lead', 'topic' => 'course', 'subject' => $this->leadSubject('course'), 'message' => $message]]
            ), $classification),
            'greeting' => $this->response([
                'Hello. Ask me about training programs, mentorship, workshops, placements, or support.',
            ], [
                ['label' => 'Training Programs', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'ट्रेनिंग प्रोग्राम' : 'training programs'],
                ['label' => 'Mentorship', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'मेंटरशिप' : 'mentorship'],
                ['label' => 'Workshop', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'वर्कशॉप' : 'workshops'],
            ], $classification),
            default => $this->response([
                'I can help with training programs, mentorship, workshops, placements, certificates, login, and support.',
                'Ask a more specific question and I will guide you.',
            ], [
                ['label' => 'Training Programs', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'ट्रेनिंग प्रोग्राम' : 'training programs'],
                ['label' => 'Mentorship', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'मेंटरशिप' : 'mentorship'],
                ['label' => 'Workshop', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'वर्कशॉप' : 'workshops'],
                ['label' => 'Support', 'type' => 'prompt', 'prompt' => $language === 'hi' ? 'टीम से संपर्क' : 'contact team'],
            ], $classification),
        };
    }

    private function classify(string $message): array
    {
        $tokens = $this->tokens($message);
        $scores = [];

        foreach (self::INTENT_MODEL as $intent => $examples) {
            $intentTokens = $this->tokens(implode(' ', $examples));
            $overlap = array_intersect($tokens, $intentTokens);
            $phraseBoost = 0;

            foreach ($examples as $example) {
                foreach (array_filter(explode(' ', Str::lower($example)), fn ($term) => mb_strlen($term) > 3) as $term) {
                    if (Str::contains(Str::lower($message), $term)) {
                        $phraseBoost += 0.35;
                    }
                }
            }

            $scores[$intent] = count($overlap) + $phraseBoost;
        }

        arsort($scores);
        $intent = (string) array_key_first($scores);
        $score = (float) reset($scores);

        return [
            'intent' => $score > 0 ? $intent : 'fallback',
            'confidence' => round(min(0.99, $score / 6), 2),
            'scores' => array_map(fn ($value) => round((float) $value, 2), $scores),
        ];
    }

    private function rankCourses(string $message, array $context): array
    {
        $tokens = $this->tokens($message);

        return collect($this->allCourses($context))
            ->map(function (array $course) use ($tokens) {
                $haystack = implode(' ', Arr::only($course, ['title', 'level', 'language', 'duration', 'campus', 'schedule', 'audience']));
                $courseTokens = $this->tokens($haystack);
                $score = count(array_intersect($tokens, $courseTokens));

                return $course + ['_score' => $score];
            })
            ->filter(fn (array $course) => $course['_score'] >= 1 && collect($this->tokens((string) $course['title']))->intersect($tokens)->isNotEmpty())
            ->sortByDesc('_score')
            ->values()
            ->map(fn (array $course) => Arr::except($course, ['_score']))
            ->all();
    }

    private function response(array $lines, array $actions, array $classification, string $source = 'model', ?string $navigateTo = null): array
    {
        return array_filter([
            'ok' => true,
            'html' => collect($lines)->map(fn ($line) => '<p>'.$this->localizeLine($line).'</p>')->implode(''),
            'actions' => $this->localizeActions($actions),
            'navigateTo' => $navigateTo,
            'model' => [
                'name' => 'cyi-intent-ranker-v1',
                'source' => $source,
                'intent' => $classification['intent'],
                'confidence' => $classification['confidence'],
            ],
        ], fn ($value) => $value !== null);
    }

    private function workshopResponse(string $message, array $context, array $classification): array
    {
        $workshops = (array) Arr::get($context, 'workshops', []);
        $hasWorkshops = $workshops !== [];

        return $this->response([
            'The workshop section is live.',
            $hasWorkshops
                ? 'Current workshop options: '.$this->e($this->listTitles($workshops)).'.'
                : 'No active workshop is listed right now. You can still raise a workshop inquiry.',
        ], array_values(array_filter([
            Arr::get($context, 'routes.workshop') ? ['label' => 'Open Workshop Page', 'type' => 'link', 'href' => Arr::get($context, 'routes.workshop')] : null,
            [
                'label' => 'Workshop Inquiry',
                'type' => 'lead',
                'topic' => 'workshop',
                'subject' => $this->leadSubject('workshop'),
                'message' => $message,
                'workshopLookup' => $hasWorkshops ? 'available_listed' : 'no_active_workshop',
            ],
        ])), $classification);
    }

    private function navigationTarget(string $message, array $context, array $courses): ?array
    {
        if ($courses !== [] && Arr::get($courses[0], 'url')) {
            return ['label' => $courses[0]['title'], 'href' => $courses[0]['url']];
        }

        $targets = [
            ['label' => 'Home Page', 'href' => Arr::get($context, 'routes.home'), 'terms' => ['home', 'homepage']],
            ['label' => 'Training Programs Page', 'href' => Arr::get($context, 'routes.courses'), 'terms' => ['course', 'courses', 'training', 'catalog']],
            ['label' => 'Mentorship Page', 'href' => Arr::get($context, 'routes.mentorship'), 'terms' => ['mentorship', 'mentor', 'roadmap']],
            ['label' => 'Workshop Page', 'href' => Arr::get($context, 'routes.workshop'), 'terms' => ['workshop', 'bootcamp']],
            ['label' => 'Placement Page', 'href' => Arr::get($context, 'routes.placement'), 'terms' => ['placement', 'job']],
            ['label' => 'Contact Page', 'href' => Arr::get($context, 'routes.contact'), 'terms' => ['contact', 'support', 'call']],
            ['label' => 'About Page', 'href' => Arr::get($context, 'routes.about'), 'terms' => ['about']],
            ['label' => 'Career Paths Page', 'href' => Arr::get($context, 'routes.career_paths'), 'terms' => ['career path', 'career paths', 'roadmap']],
            ['label' => 'Careers Page', 'href' => Arr::get($context, 'routes.careers'), 'terms' => ['careers', 'job opening']],
            ['label' => 'Corporate Training Page', 'href' => Arr::get($context, 'routes.corporate_training'), 'terms' => ['corporate training', 'company training']],
            ['label' => 'Login Page', 'href' => Arr::get($context, 'routes.login'), 'terms' => ['login', 'sign in']],
            ['label' => 'Register Page', 'href' => Arr::get($context, 'routes.register'), 'terms' => ['register', 'signup', 'sign up']],
        ];

        foreach ($targets as $target) {
            if ($target['href'] && Str::contains(Str::lower($message), $target['terms'])) {
                return Arr::only($target, ['label', 'href']);
            }
        }

        return null;
    }

    private function publicPageActions(array $context): array
    {
        return collect([
            ['label' => 'Home Page', 'href' => Arr::get($context, 'routes.home')],
            ['label' => 'Training Programs Page', 'href' => Arr::get($context, 'routes.courses')],
            ['label' => 'Mentorship Page', 'href' => Arr::get($context, 'routes.mentorship')],
            ['label' => 'Workshop Page', 'href' => Arr::get($context, 'routes.workshop')],
            ['label' => 'Placement Page', 'href' => Arr::get($context, 'routes.placement')],
            ['label' => 'Contact Page', 'href' => Arr::get($context, 'routes.contact')],
            ['label' => 'About Page', 'href' => Arr::get($context, 'routes.about')],
            ['label' => 'Career Paths Page', 'href' => Arr::get($context, 'routes.career_paths')],
            ['label' => 'Careers Page', 'href' => Arr::get($context, 'routes.careers')],
            ['label' => 'Corporate Training Page', 'href' => Arr::get($context, 'routes.corporate_training')],
            ['label' => 'Login Page', 'href' => Arr::get($context, 'routes.login')],
            ['label' => 'Register Page', 'href' => Arr::get($context, 'routes.register')],
        ])
            ->filter(fn (array $target) => filled($target['href']))
            ->map(fn (array $target) => ['label' => $target['label'], 'type' => 'link', 'href' => $target['href']])
            ->values()
            ->all();
    }

    private function courseActions(array $courses, array $context, string $fallbackLabel = 'All Training Programs', ?string $fallbackUrl = null): array
    {
        $actions = collect($courses)
            ->take(3)
            ->filter(fn (array $course) => filled(Arr::get($course, 'url')))
            ->map(fn (array $course) => [
                'label' => Str::limit((string) $course['title'], 27),
                'type' => 'link',
                'href' => $course['url'],
            ])
            ->values()
            ->all();

        $fallbackUrl ??= Arr::get($context, 'routes.courses');
        if ($fallbackUrl) {
            $actions[] = ['label' => $fallbackLabel, 'type' => 'link', 'href' => $fallbackUrl];
        }

        return $actions;
    }

    private function allCourses(array $context): array
    {
        return array_values(array_merge(
            (array) Arr::get($context, 'online_courses', []),
            (array) Arr::get($context, 'offline_courses', []),
        ));
    }

    private function courseSummary(array $course): string
    {
        $summary = [];
        $labels = $this->language === 'hi'
            ? ['price' => 'फीस', 'level' => 'लेवल', 'duration' => 'अवधि', 'language' => 'भाषा', 'campus' => 'कैंपस', 'schedule' => 'शेड्यूल', 'audience' => 'किनके लिए']
            : ['price' => 'Price', 'level' => 'Level', 'duration' => 'Duration', 'language' => 'Language', 'campus' => 'Campus', 'schedule' => 'Schedule', 'audience' => 'For'];

        foreach ($labels as $key => $label) {
            if (filled(Arr::get($course, $key))) {
                $summary[] = $label.': '.Arr::get($course, $key);
            }
        }

        return implode(' | ', $summary);
    }

    private function wantsAllPublicPages(string $message): bool
    {
        return Str::contains(Str::lower($message), ['all public pages', 'all pages', 'public pages', 'website pages', 'home pages']);
    }

    private function wantsLead(string $message): bool
    {
        return Str::contains(Str::lower($message), ['contact me', 'call me', 'reach me', 'get in touch', 'book a call', 'i need help', 'i need support', 'connect me', 'team contact']);
    }

    private function leadTopic(string $intent): string
    {
        return match ($intent) {
            'training', 'offline' => 'course',
            'workshop', 'mentorship', 'placement' => $intent,
            'contact' => 'support',
            default => 'general',
        };
    }

    private function leadSubject(string $topic): string
    {
        return match ($topic) {
            'course' => 'Training program inquiry',
            'workshop' => 'Workshop inquiry',
            'mentorship' => 'Mentorship request',
            'placement' => 'Placement support request',
            'career' => 'Career inquiry',
            'support' => 'Support request',
            default => 'Chatbot inquiry',
        };
    }

    private function listTitles(array $items): string
    {
        if ($items === []) {
            return $this->language === 'hi' ? 'मौजूदा कैटलॉग' : 'the current catalog';
        }

        return collect($items)->take(3)->pluck('title')->filter()->implode(', ') ?: ($this->language === 'hi' ? 'मौजूदा कैटलॉग' : 'the current catalog');
    }

    private function tokens(string $text): array
    {
        $text = Str::lower(strip_tags($text));
        preg_match_all('/[\pL\pN]+/u', $text, $matches);

        return collect($matches[0] ?? [])
            ->map(fn ($token) => trim($token))
            ->filter(fn ($token) => mb_strlen($token) > 1)
            ->unique()
            ->values()
            ->all();
    }

    private function e(string $value): string
    {
        return e($value, false);
    }

    private function localizeLine(string $line): string
    {
        if ($this->language !== 'hi') {
            return $line;
        }

        $exact = [
            'Here are the public pages you can open right now.' => 'ये वे पब्लिक पेज हैं जिन्हें आप अभी खोल सकते हैं।',
            'Tap any page below and I will redirect you.' => 'नीचे किसी भी पेज पर टैप करें, मैं आपको वहां ले जाऊंगा।',
            'Redirecting now.' => 'अब रीडायरेक्ट किया जा रहा है।',
            'You can open the training program page for full details.' => 'पूरी जानकारी के लिए आप ट्रेनिंग प्रोग्राम पेज खोल सकते हैं।',
            'I can send this request to the team for you.' => 'मैं आपकी यह रिक्वेस्ट टीम तक भेज सकता हूं।',
            'Eligible learners can access certificates after completing their training program requirements.' => 'योग्य विद्यार्थी ट्रेनिंग प्रोग्राम की आवश्यकताएं पूरी करने के बाद सर्टिफिकेट प्राप्त कर सकते हैं।',
            'Certificates are available inside the LMS after eligible training program completion. Logged-in learners can access their certificates from the student certificate area when the program requirements are completed.' => 'ट्रेनिंग प्रोग्राम की आवश्यकताएं पूरी होने के बाद सर्टिफिकेट LMS में उपलब्ध होते हैं। लॉग-इन विद्यार्थी इन्हें स्टूडेंट सर्टिफिकेट एरिया से देख सकते हैं।',
            'Mentorship is available for guidance, planning, and next-step support.' => 'मेंटरशिप मार्गदर्शन, योजना और अगले कदमों की सहायता के लिए उपलब्ध है।',
            'If you want, I can send a mentorship request to the team.' => 'अगर आप चाहें, तो मैं टीम को मेंटरशिप रिक्वेस्ट भेज सकता हूं।',
            'This LMS includes placement-focused guidance and career support.' => 'इस LMS में प्लेसमेंट-केंद्रित मार्गदर्शन और करियर सपोर्ट शामिल है।',
            'Placement support is a public focus area in this LMS. The placement page, success stories, and career guidance sections are the best places to explore current support details.' => 'इस LMS में प्लेसमेंट सपोर्ट एक मुख्य फोकस है। मौजूदा जानकारी के लिए प्लेसमेंट पेज, सक्सेस स्टोरीज और करियर गाइडेंस सेक्शन देखें।',
            'You can log in if you already have an account, or register as a new learner.' => 'अगर आपका अकाउंट है तो लॉग इन करें, या नए विद्यार्थी के रूप में रजिस्टर करें।',
            'You can explore training programs from the catalog.' => 'आप कैटलॉग से ट्रेनिंग प्रोग्राम देख सकते हैं।',
            'Hello. Ask me about training programs, mentorship, workshops, placements, or support.' => 'नमस्ते। आप ट्रेनिंग प्रोग्राम, मेंटरशिप, वर्कशॉप, प्लेसमेंट या सपोर्ट के बारे में पूछ सकते हैं।',
            'I can help with training programs, mentorship, workshops, placements, certificates, login, and support.' => 'मैं ट्रेनिंग प्रोग्राम, मेंटरशिप, वर्कशॉप, प्लेसमेंट, सर्टिफिकेट, लॉगिन और सपोर्ट में मदद कर सकता हूं।',
            'Ask a more specific question and I will guide you.' => 'थोड़ा और स्पष्ट सवाल पूछें, मैं आपको गाइड करूंगा।',
            'The workshop section is live.' => 'वर्कशॉप सेक्शन उपलब्ध है।',
            'No active workshop is listed right now. You can still raise a workshop inquiry.' => 'अभी कोई एक्टिव वर्कशॉप लिस्टेड नहीं है। फिर भी आप वर्कशॉप इन्क्वायरी भेज सकते हैं।',
            'Offline options are available through the training program catalog.' => 'ऑफलाइन विकल्प ट्रेनिंग प्रोग्राम कैटलॉग में उपलब्ध हैं।',
        ];

        if (isset($exact[$line])) {
            return $exact[$line];
        }

        if (preg_match('/^Taking you to the <strong>(.*?)<\/strong>\.$/', $line, $matches)) {
            return '<strong>'.$this->localizeLabel($matches[1]).'</strong> पेज पर ले जा रहा हूं।';
        }

        if (preg_match('/^Some current options include (.*?)\.$/', $line, $matches)) {
            return 'अभी के कुछ विकल्प हैं: '.$matches[1].'।';
        }

        if (preg_match('/^Some current offline choices include (.*?)\.$/', $line, $matches)) {
            return 'अभी के कुछ ऑफलाइन विकल्प हैं: '.$matches[1].'।';
        }

        if (preg_match('/^Current workshop options: (.*?)\.$/', $line, $matches)) {
            return 'अभी की वर्कशॉप विकल्प: '.$matches[1].'।';
        }

        if (preg_match('/^You can contact the team directly at <strong>(.*?)<\/strong> or <strong>(.*?)<\/strong>\.$/', $line, $matches)) {
            return 'आप टीम से सीधे <strong>'.$matches[1].'</strong> या <strong>'.$matches[2].'</strong> पर संपर्क कर सकते हैं।';
        }

        return $line;
    }

    private function localizeActions(array $actions): array
    {
        if ($this->language !== 'hi') {
            return $actions;
        }

        return collect($actions)
            ->map(function (array $action) {
                if (isset($action['label'])) {
                    $action['label'] = $this->localizeLabel((string) $action['label']);
                }

                if (isset($action['subject'])) {
                    $action['subject'] = $this->localizeSubject((string) $action['subject']);
                }

                return $action;
            })
            ->all();
    }

    private function localizeLabel(string $label): string
    {
        return [
            'Open Now' => 'अभी खोलें',
            'Send Inquiry' => 'इन्क्वायरी भेजें',
            'Student Login' => 'स्टूडेंट लॉगिन',
            'Training Programs' => 'ट्रेनिंग प्रोग्राम',
            'Open Mentorship' => 'मेंटरशिप खोलें',
            'Request Mentorship' => 'मेंटरशिप रिक्वेस्ट',
            'Open Workshop Page' => 'वर्कशॉप पेज खोलें',
            'Workshop Inquiry' => 'वर्कशॉप इन्क्वायरी',
            'Placement Page' => 'प्लेसमेंट पेज',
            'Placement Help' => 'प्लेसमेंट मदद',
            'Contact Page' => 'कॉन्टैक्ट पेज',
            'Send Message' => 'मैसेज भेजें',
            'Offline Training Programs' => 'ऑफलाइन ट्रेनिंग प्रोग्राम',
            'Login' => 'लॉगिन',
            'Register' => 'रजिस्टर',
            'Browse Training Programs' => 'ट्रेनिंग प्रोग्राम देखें',
            'Training Program Guidance' => 'ट्रेनिंग प्रोग्राम गाइडेंस',
            'Mentorship' => 'मेंटरशिप',
            'Workshop' => 'वर्कशॉप',
            'Support' => 'सपोर्ट',
            'All Training Programs' => 'सभी ट्रेनिंग प्रोग्राम',
            'Home Page' => 'होम पेज',
            'Training Programs Page' => 'ट्रेनिंग प्रोग्राम पेज',
            'Mentorship Page' => 'मेंटरशिप पेज',
            'Workshop Page' => 'वर्कशॉप पेज',
            'About Page' => 'अबाउट पेज',
            'Career Paths Page' => 'करियर पाथ पेज',
            'Careers Page' => 'करियर पेज',
            'Corporate Training Page' => 'कॉर्पोरेट ट्रेनिंग पेज',
            'Login Page' => 'लॉगिन पेज',
            'Register Page' => 'रजिस्टर पेज',
        ][$label] ?? $label;
    }

    private function localizeSubject(string $subject): string
    {
        return [
            'Training program inquiry' => 'ट्रेनिंग प्रोग्राम इन्क्वायरी',
            'Workshop inquiry' => 'वर्कशॉप इन्क्वायरी',
            'Mentorship request' => 'मेंटरशिप रिक्वेस्ट',
            'Placement support request' => 'प्लेसमेंट सपोर्ट रिक्वेस्ट',
            'Career inquiry' => 'करियर इन्क्वायरी',
            'Support request' => 'सपोर्ट रिक्वेस्ट',
            'Chatbot inquiry' => 'चैटबॉट इन्क्वायरी',
        ][$subject] ?? $subject;
    }
}
