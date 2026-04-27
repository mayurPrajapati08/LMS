@php
    $heroStats = [
        ['value' => '40+', 'label' => 'live workshop editions'],
        ['value' => '92%', 'label' => 'learners who finish the guided task'],
        ['value' => '7 Days', 'label' => 'post-session notes and resources'],
    ];

    $experienceMoments = [
        [
            'icon' => 'bolt',
            'title' => 'Concept Clarity Before You Build',
            'description' => 'Every workshop begins with a simple explanation of the topic, the workflow, and the exact outcome learners will create during the session.',
            'points' => ['Beginner-friendly explanation', 'Clear session goal', 'Step-by-step roadmap'],
            'image' => asset('images/live projects.jpeg'),
        ],
        [
            'icon' => 'terminal',
            'title' => 'Live Practical Build With Mentors',
            'description' => 'Students build in real time with mentor guidance, practical tasks, and live walkthroughs that make the session useful, not just theoretical.',
            'points' => ['Hands-on task execution', 'Tool-by-tool guidance', 'Real project-style practice'],
            'image' => asset('images/live projects.jpeg'),
        ],
        [
            'icon' => 'groups',
            'title' => 'Support, Review, And Takeaway Resources',
            'description' => 'Participants can ask questions, get live support, and leave with notes, practice material, and a clearer next step after the workshop.',
            'points' => ['Live Q and A', 'Mentor feedback', 'Practice resources after session'],
            'image' => asset('images/live projects.jpeg'),
        ],
    ];

    $workshopFlow = [
        ['step' => '01', 'title' => 'Join with clarity', 'copy' => 'We set the topic, tools, and learning outcome first so every learner understands what will be covered.'],
        ['step' => '02', 'title' => 'Build with guidance', 'copy' => 'Mentors teach, demonstrate, and help students execute the practical part live during the session.'],
        ['step' => '03', 'title' => 'Continue after class', 'copy' => 'Students leave with revision points, tasks, and resources they can use to keep practicing with confidence.'],
    ];

    $featuredWorkshops = $featuredWorkshops ?? [];

    $pastWorkshops = [
        [
            'title' => 'Python Automation Essentials',
            'date' => 'March 2026',
            'attendees' => '120+ participants',
            'summary' => 'A practical lab on automation logic, task scripting, and beginner-friendly workflow thinking.',
            'cover' => asset('images/carrer paths/full stack.jpeg'),
            'focus' => 'Automation basics, repeatable task thinking, and confidence with starter scripts',
            'gallery' => [
                asset('images/carrer paths/full stack.jpeg'),
                asset('images/carrer paths/web development.jpeg'),
                asset('images/carrer paths/mobile application.jpeg'),
            ],
            'tasks' => [
                'Built a mini automation routine with Python basics and input handling',
                'Mapped repetitive work into task-friendly script logic',
                'Reviewed mentor feedback on workflow cleanup and output formatting',
            ],
            'outcomes' => [
                'Participants understood how automation projects are framed in real teams',
                'Learners left with starter files, task notes, and next-step practice guidance',
            ],
        ],
        [
            'title' => 'Power BI Insight Workshop',
            'date' => 'February 2026',
            'attendees' => '95+ participants',
            'summary' => 'A live dashboard workshop focused on business metrics, layout choices, and presentation quality.',
            'cover' => asset('images/carrer paths/power bi.jpeg'),
            'focus' => 'Business dashboards, KPI storytelling, and polished analyst presentation',
            'gallery' => [
                asset('images/carrer paths/power bi.jpeg'),
                asset('images/carrer paths/data analytics with ai.jpeg'),
                asset('images/carrer paths/sql development.jpeg'),
            ],
            'tasks' => [
                'Designed a recruiter-friendly dashboard story using practical sales data',
                'Created KPI blocks, filters, and visual hierarchy for stakeholder readability',
                'Improved presentation quality with mentor review suggestions',
            ],
            'outcomes' => [
                'Learners practiced turning raw data into a polished visual narrative',
                'The session ended with a portfolio-oriented dashboard checklist',
            ],
        ],
        [
            'title' => 'Career Launch Resume Clinic',
            'date' => 'January 2026',
            'attendees' => '160+ participants',
            'summary' => 'A high-energy workshop built around resume improvement, project storytelling, and interview positioning.',
            'cover' => asset('images/carrer paths/data science with ai.jpeg'),
            'focus' => 'Resume structure, project narrative, and interview-ready presentation',
            'gallery' => [
                asset('images/carrer paths/data science with ai.jpeg'),
                asset('images/carrer paths/genrative ai.jpeg'),
                asset('images/carrer paths/cloud computing.jpeg'),
            ],
            'tasks' => [
                'Refined resume bullet points with impact-focused language',
                'Positioned projects for internship and job applications',
                'Practiced mentor-approved self-introduction structure',
            ],
            'outcomes' => [
                'Attendees gained a sharper and more professional application narrative',
                'Each participant received a post-workshop checklist for continued improvement',
            ],
        ],
    ];
@endphp

<x-home.marketing-layout title="Workshop | CodeInYourself" bodyClass="workshop-page">
    <x-slot:head>
        <style>
            .workshop-page-shell {
                overflow-x: clip;
            }

            @supports not (overflow: clip) {
                .workshop-page-shell {
                    overflow-x: hidden;
                }
            }

            .workshop-hero {
                position: relative;
                width: 100vw;
                margin-left: calc(50% - 50vw);
                margin-right: calc(50% - 50vw);
                overflow: hidden;
                background:
                    radial-gradient(circle at 12% 16%, rgba(255,255,255,0.16), transparent 18%),
                    radial-gradient(circle at 86% 12%, rgba(216,180,254,0.20), transparent 22%),
                    radial-gradient(circle at 74% 76%, rgba(255,255,255,0.10), transparent 24%),
                    linear-gradient(135deg, #080211 0%, #1b0735 26%, #4c1d95 60%, #8b5cf6 100%);
            }

            .workshop-hero::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
                background-size: 88px 88px;
                mask-image: radial-gradient(circle at center, black 26%, transparent 86%);
                opacity: 0.22;
                pointer-events: none;
            }

            .workshop-hero::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(8,2,17,0.02) 0%, rgba(8,2,17,0.24) 100%);
                pointer-events: none;
            }

            .workshop-hero-orb {
                position: absolute;
                border-radius: 9999px;
                filter: blur(12px);
                opacity: 0.9;
                pointer-events: none;
            }

            .workshop-hero-orb.orb-one {
                left: -6rem;
                top: 6rem;
                width: 18rem;
                height: 18rem;
                background: radial-gradient(circle, rgba(192,132,252,0.28), rgba(192,132,252,0));
                animation: float-aurora 16s ease-in-out infinite alternate;
            }

            .workshop-hero-orb.orb-two {
                right: -4rem;
                bottom: 4rem;
                width: 16rem;
                height: 16rem;
                background: radial-gradient(circle, rgba(255,255,255,0.20), rgba(255,255,255,0));
                animation: float-aurora 18s ease-in-out infinite alternate;
            }

            .hero-badge-pill {
                background: rgba(255,255,255,0.10);
                border: 1px solid rgba(255,255,255,0.14);
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.10);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .hero-stage {
                position: relative;
                display: grid;
                grid-template-columns: minmax(0, 0.82fr) minmax(0, 1fr);
                align-items: start;
                gap: 1.35rem;
                min-height: auto;
                padding-top: 1.5rem;
            }

            .hero-stage-grid {
                position: absolute;
                inset: 8% 0 12% auto;
                width: 68%;
                background-image:
                    linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
                background-size: 2.8rem 2.8rem;
                mask-image: radial-gradient(circle at center, black 34%, transparent 82%);
                opacity: 0.45;
                pointer-events: none;
            }

            .hero-stage-card {
                position: relative;
                border: 1px solid rgba(255,255,255,0.14);
                background: linear-gradient(180deg, rgba(255,255,255,0.20), rgba(255,255,255,0.07));
                box-shadow: 0 24px 56px rgba(9, 2, 24, 0.24);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                z-index: 2;
                width: 100%;
            }

            .hero-stage-card.primary {
                grid-column: 1 / -1;
                justify-self: end;
                max-width: 31rem;
                padding: 1.4rem;
                border-radius: 2rem;
                z-index: 1;
            }

            .hero-stage-card.secondary {
                align-self: start;
                margin-top: 0.5rem;
                max-width: 16rem;
                padding: 1.15rem;
                border-radius: 1.7rem;
            }

            .hero-stage-card.tertiary {
                justify-self: end;
                margin-top: 2.6rem;
                max-width: 18.25rem;
                padding: 1.15rem;
                border-radius: 1.6rem;
            }

            .hero-stage-screen {
                position: relative;
                overflow: hidden;
                border-radius: 1.5rem;
                border: 1px solid rgba(255,255,255,0.10);
                background:
                    linear-gradient(135deg, rgba(13,6,32,0.82), rgba(92,38,178,0.64)),
                    radial-gradient(circle at top right, rgba(255,255,255,0.14), transparent 24%);
                min-height: 16rem;
            }

            .hero-stage-screen::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 18% 24%, rgba(196,181,253,0.22), transparent 18%),
                    radial-gradient(circle at 76% 72%, rgba(255,255,255,0.10), transparent 16%);
                pointer-events: none;
            }

            .hero-stage-line {
                height: 0.45rem;
                border-radius: 9999px;
                background: linear-gradient(90deg, rgba(216,180,254,0.85), rgba(255,255,255,0.18));
            }

            .hero-stage-chip {
                border: 1px solid rgba(255,255,255,0.10);
                background: rgba(255,255,255,0.08);
                backdrop-filter: blur(10px);
            }

            .workshop-panel {
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(220, 205, 246, 0.8);
                background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(248,243,255,0.92));
                box-shadow: 0 24px 58px rgba(88, 28, 135, 0.10);
            }

            .workshop-panel::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.10), transparent 24%),
                    radial-gradient(circle at bottom left, rgba(124,58,237,0.08), transparent 22%);
                pointer-events: none;
            }

            .feature-icon-shell {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.9rem;
                height: 2.9rem;
                border-radius: 0.95rem;
                background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(168,85,247,0.18));
                color: #6d28d9;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
            }

            .experience-card {
                display: flex;
                flex-direction: column;
                border: 1px solid rgba(225, 214, 245, 0.88);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,247,255,0.95));
                box-shadow: 0 18px 40px rgba(88, 28, 135, 0.09);
            }

            .experience-card-media {
                position: relative;
                z-index: 1;
                height: clamp(8.5rem, 18vw, 10.5rem);
                overflow: hidden;
                background: #12081f;
            }

            .experience-card-media img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
                object-position: center;
            }

            .experience-card-body {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                gap: 0.9rem;
                padding: 1.1rem;
            }

            .experience-card-heading {
                display: flex;
                align-items: flex-start;
                gap: 0.85rem;
            }

            .experience-card-copy {
                min-width: 0;
                flex: 1 1 auto;
            }

            .experience-point {
                display: inline-flex;
                align-items: center;
                min-height: 1.9rem;
                border-radius: 9999px;
                background: rgba(124, 58, 237, 0.08);
                padding: 0.42rem 0.72rem;
                color: #6d28d9;
                font-size: 0.68rem;
                font-weight: 700;
                line-height: 1.2;
            }

            .timeline-row {
                position: relative;
                padding-left: 4.5rem;
            }

            .timeline-row::before {
                content: "";
                position: absolute;
                left: 1.45rem;
                top: 3.2rem;
                bottom: -1.75rem;
                width: 1px;
                background: linear-gradient(180deg, rgba(124,58,237,0.28), rgba(168,85,247,0));
            }

            .timeline-row:last-child::before {
                display: none;
            }

            .timeline-step {
                position: absolute;
                left: 0;
                top: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 3rem;
                height: 3rem;
                border-radius: 9999px;
                background: linear-gradient(135deg, #6d28d9, #a855f7);
                color: #fff;
                font-family: "Space Grotesk", ui-sans-serif, system-ui, sans-serif;
                font-weight: 800;
                box-shadow: 0 16px 34px rgba(124, 58, 237, 0.24);
            }

            .program-card {
                position: relative;
                overflow: hidden;
                border-radius: 2rem;
                border: 1px solid rgba(255,255,255,0.12);
                box-shadow: 0 26px 70px rgba(22, 8, 50, 0.16);
            }

            .program-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.12), transparent 32%),
                    linear-gradient(180deg, transparent 58%, rgba(7,2,16,0.26) 100%);
                pointer-events: none;
            }

            .program-pill {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.12);
                backdrop-filter: blur(12px);
            }

            .workshop-list-card {
                position: relative;
                display: flex;
                flex-direction: column;
                height: 100%;
                overflow: hidden;
                border-radius: 2rem;
                border: 1px solid rgba(225, 214, 245, 0.92);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,243,255,0.96));
                box-shadow:
                    0 24px 56px rgba(88, 28, 135, 0.10),
                    inset 0 1px 0 rgba(255,255,255,0.94);
                transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
            }

            .workshop-list-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at top right, rgba(168,85,247,0.10), transparent 24%),
                    radial-gradient(circle at bottom left, rgba(124,58,237,0.08), transparent 26%);
                pointer-events: none;
            }

            .workshop-list-card:hover {
                transform: translateY(-6px);
                border-color: rgba(192,132,252,0.85);
                box-shadow:
                    0 30px 70px rgba(88, 28, 135, 0.15),
                    inset 0 1px 0 rgba(255,255,255,0.96);
            }

            .workshop-card-hero {
                position: relative;
                padding: 1.55rem;
                min-height: 15.5rem;
                color: #fff;
            }

            .workshop-card-hero::after {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.08), transparent 36%),
                    linear-gradient(180deg, transparent 42%, rgba(8,2,17,0.24) 100%);
                pointer-events: none;
            }

            .workshop-card-chip {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.12);
                backdrop-filter: blur(12px);
            }

            .workshop-card-body {
                position: relative;
                z-index: 1;
                display: flex;
                flex: 1 1 auto;
                flex-direction: column;
                padding: 1.5rem;
            }

            .workshop-card-summary {
                display: grid;
                gap: 1rem;
                grid-template-columns: minmax(0, 1fr) auto;
                align-items: end;
                padding-bottom: 1.2rem;
                border-bottom: 1px solid rgba(233,225,247,0.92);
            }

            .workshop-price-badge {
                display: inline-flex;
                flex-direction: column;
                align-items: flex-end;
                justify-content: center;
                gap: 0.2rem;
                min-width: 7.5rem;
                border-radius: 1.3rem;
                border: 1px solid rgba(218,203,242,0.9);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(243,236,255,0.96));
                padding: 0.9rem 1rem;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.94);
            }

            .workshop-quick-strip {
                display: grid;
                gap: 0.8rem;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .workshop-quick-item {
                border-radius: 1.2rem;
                border: 1px solid rgba(231,222,247,0.92);
                background: linear-gradient(180deg, rgba(252,249,255,0.98), rgba(247,242,255,0.94));
                padding: 0.95rem 1rem;
            }

            .workshop-meta-grid {
                display: grid;
                gap: 0.85rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .workshop-info-item {
                border-radius: 1.25rem;
                border: 1px solid rgba(226, 215, 246, 0.94);
                background: rgba(255,255,255,0.88);
                padding: 1rem 1.05rem;
                box-shadow: inset 0 1px 0 rgba(255,255,255,0.94);
            }

            .workshop-side-panel {
                border-radius: 1.45rem;
                border: 1px solid rgba(226, 215, 246, 0.92);
                background: linear-gradient(180deg, rgba(252,249,255,0.98), rgba(245,238,255,0.96));
                padding: 1rem;
            }

            .workshop-highlight-list {
                display: grid;
                gap: 0.8rem;
            }

            .workshop-highlight-item {
                display: flex;
                align-items: flex-start;
                gap: 0.8rem;
                border-radius: 1.2rem;
                border: 1px solid rgba(236, 228, 249, 0.92);
                background: rgba(255,255,255,0.82);
                padding: 0.9rem 1rem;
                color: #4b5563;
            }

            .past-card {
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,243,255,0.94));
                border: 1px solid rgba(220, 205, 246, 0.78);
                box-shadow: 0 24px 56px rgba(88, 28, 135, 0.10);
            }

            .past-cover {
                position: relative;
                overflow: hidden;
                min-height: 15rem;
                background: linear-gradient(135deg, rgba(18,5,32,0.92), rgba(139,92,246,0.62));
            }

            .past-cover::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, transparent 42%, rgba(10,3,24,0.48) 100%);
                pointer-events: none;
            }

            .detail-modal {
                position: fixed;
                inset: 0;
                z-index: 200;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100dvh;
                overflow: hidden;
                padding: max(1rem, env(safe-area-inset-top)) 1rem max(1rem, env(safe-area-inset-bottom));
                background: rgba(9, 2, 24, 0.72);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.25s ease, visibility 0.25s ease;
            }

            .detail-modal.is-open {
                opacity: 1;
                visibility: visible;
            }

            .detail-modal-panel {
                width: min(100%, 72rem);
                max-height: calc(100dvh - 2rem);
                margin: auto;
                overflow-x: hidden;
                overflow-y: auto;
                overscroll-behavior: contain;
                border-radius: 2rem;
                border: 1px solid rgba(220, 205, 246, 0.78);
                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(248,243,255,0.94));
                box-shadow: 0 30px 90px rgba(12, 3, 33, 0.28);
            }

            .detail-cover {
                position: relative;
                overflow: hidden;
                min-height: 19rem;
                border-radius: 1.8rem;
                background: linear-gradient(135deg, #120520 0%, #4c1d95 60%, #a855f7 100%);
            }

            .detail-cover::after {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.04), transparent 30%),
                    linear-gradient(180deg, transparent 42%, rgba(8,2,17,0.56) 100%);
                pointer-events: none;
            }

            .detail-stat-chip {
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.10);
                backdrop-filter: blur(12px);
            }

            .detail-gallery {
                display: grid;
                gap: 0.9rem;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .detail-gallery img {
                width: 100%;
                height: 10rem;
                object-fit: cover;
                border-radius: 1.25rem;
                border: 1px solid rgba(220, 205, 246, 0.72);
            }

            .join-modal-panel {
                width: min(100%, 78rem);
                max-height: calc(100dvh - 2rem);
                border-radius: 2.15rem;
                overflow-x: hidden;
                overflow-y: auto;
            }

            .join-hero-pane {
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                background:
                    radial-gradient(circle at 20% 16%, rgba(255,255,255,0.16), transparent 18%),
                    radial-gradient(circle at 82% 14%, rgba(216,180,254,0.18), transparent 20%),
                    linear-gradient(135deg, #0a0315 0%, #240846 32%, #5820aa 72%, #9f67ff 100%);
            }

            .join-modal-grid {
                min-height: min(56rem, calc(100dvh - 2rem));
            }

            .join-form-pane {
                overflow: visible;
            }

            .join-hero-pane::before {
                content: "";
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
                background-size: 72px 72px;
                mask-image: radial-gradient(circle at center, black 28%, transparent 84%);
                opacity: 0.24;
                pointer-events: none;
            }

            .join-form-card {
                border: 1px solid rgba(220, 205, 246, 0.76);
                background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,243,255,0.94));
                box-shadow: 0 20px 54px rgba(88, 28, 135, 0.10);
            }

            .join-meta-grid {
                display: grid;
                gap: 0.9rem;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .join-side-card {
                position: relative;
                z-index: 1;
                border: 1px solid rgba(255,255,255,0.14);
                background: rgba(255,255,255,0.08);
                backdrop-filter: blur(16px);
            }

            .join-side-list {
                display: grid;
                gap: 0.8rem;
            }

            .join-side-list-item {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                color: rgba(255,255,255,0.78);
                font-size: 0.93rem;
                line-height: 1.7;
            }

            .join-side-list-item span:first-child {
                margin-top: 0.45rem;
                height: 0.5rem;
                width: 0.5rem;
                flex-shrink: 0;
                border-radius: 999px;
                background: #e9d5ff;
                box-shadow: 0 0 18px rgba(233, 213, 255, 0.72);
            }

            .field-shell {
                position: relative;
                overflow: hidden;
                border-radius: 1.45rem;
                border: 1px solid rgba(229, 218, 247, 0.82);
                background:
                    radial-gradient(circle at top left, rgba(168,85,247,0.08), transparent 28%),
                    linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,245,255,0.94));
                padding: 0.2rem;
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.96),
                    0 16px 34px rgba(124,58,237,0.06);
                transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            }

            .field-shell::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(115deg, rgba(255,255,255,0.32), transparent 35%, transparent 68%, rgba(255,255,255,0.14));
                pointer-events: none;
            }

            .field-shell:focus-within {
                border-color: rgba(229, 218, 247, 0.82);
                box-shadow:
                    inset 0 1px 0 rgba(255,255,255,0.96),
                    0 16px 34px rgba(124,58,237,0.06);
                transform: none;
            }

            .field-label {
                display: block;
                margin-bottom: 0.55rem;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: rgba(68, 46, 107, 0.78);
            }

            .premium-input,
            .premium-select,
            .premium-textarea {
                position: relative;
                z-index: 1;
                width: 100%;
                border-radius: 1.25rem;
                border: 0;
                background: transparent;
                padding: 1rem 1.1rem;
                font-size: 0.98rem;
                font-weight: 500;
                color: #1a1330;
                box-shadow: none;
                appearance: none;
                -webkit-appearance: none;
                outline: none;
            }

            .premium-input:focus,
            .premium-input:focus-visible,
            .premium-select:focus,
            .premium-select:focus-visible,
            .premium-textarea:focus,
            .premium-textarea:focus-visible {
                outline: none;
                border-color: transparent;
                box-shadow: none;
            }

            .premium-textarea {
                min-height: 9rem;
                resize: vertical;
                line-height: 1.8;
            }

            .premium-input::placeholder,
            .premium-textarea::placeholder {
                color: rgba(93, 78, 132, 0.52);
            }

            .premium-select {
                background-image:
                    linear-gradient(45deg, transparent 50%, rgba(109,40,217,0.72) 50%),
                    linear-gradient(135deg, rgba(109,40,217,0.72) 50%, transparent 50%);
                background-position:
                    calc(100% - 24px) calc(1.5rem),
                    calc(100% - 18px) calc(1.5rem);
                background-size: 6px 6px, 6px 6px;
                background-repeat: no-repeat;
            }

            .mode-option {
                position: relative;
            }

            .mode-option input {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }

            .mode-option span {
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 1rem;
                border: 1px solid rgba(220, 205, 246, 0.84);
                background: rgba(255,255,255,0.92);
                padding: 0.9rem 1rem;
                font-size: 0.88rem;
                font-weight: 700;
                color: #5f4d83;
                transition: all 0.2s ease;
            }

            .mode-option input:checked + span {
                border-color: rgba(124,58,237,0.48);
                background: linear-gradient(135deg, rgba(124,58,237,0.14), rgba(168,85,247,0.16));
                color: #5b21b6;
                box-shadow: 0 12px 24px rgba(124,58,237,0.12);
            }

            @media (max-width: 1024px) {
                .hero-stage {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 1rem;
                    padding-top: 0.5rem;
                }

                .hero-stage-grid {
                    display: none;
                }

                .hero-stage-card.primary,
                .hero-stage-card.secondary,
                .hero-stage-card.tertiary {
                    max-width: 100%;
                    margin-top: 0;
                    justify-self: stretch;
                }

                .join-modal-panel {
                    max-height: none;
                }
            }

            @media (max-width: 767px) {
                .detail-modal {
                    align-items: flex-start;
                    padding: max(0.75rem, env(safe-area-inset-top)) 0.75rem 0.75rem;
                }

                .detail-modal-panel,
                .join-modal-panel {
                    max-height: calc(100dvh - 1.5rem);
                    border-radius: 1.6rem;
                }

                .join-modal-grid {
                    min-height: auto;
                }

                .join-form-pane {
                    overflow: visible;
                }

                .workshop-meta-grid {
                    grid-template-columns: 1fr;
                }

                .detail-gallery {
                    grid-template-columns: 1fr;
                }

                .detail-gallery img {
                    height: 12rem;
                }

                .detail-cover {
                    min-height: 14rem;
                }

                .workshop-card-summary,
                .join-meta-grid {
                    grid-template-columns: 1fr;
                }

                .workshop-quick-strip {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </x-slot:head>

    
    <main class="workshop-page-shell pb-24 pt-5">
        <section class="workshop-hero min-h-[calc(100vh-5rem)] px-4 pb-14 pt-12 text-white sm:px-6 md:px-8 md:pb-16">
            <div class="workshop-hero-orb orb-one"></div>
            <div class="workshop-hero-orb orb-two"></div>

            <div class="relative z-10 mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1.02fr_0.98fr] lg:items-center">
                <div class="reveal">
                    <span class="hero-badge-pill inline-flex items-center gap-2 rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.24em] text-white/82">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#d8b4fe] shadow-[0_0_18px_rgba(216,180,254,0.9)]"></span>
                        Premium Live Workshop Experience
                    </span>

                    <h1 class="mt-7 max-w-3xl font-headline text-[2.25rem] font-extrabold leading-[0.96] sm:text-[2.8rem] md:text-[3.6rem] lg:text-[3.35rem]">
                        Workshops that feel
                        <span class="block text-[#ead9ff]">immersive, practical, and career-shaping.</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-[0.98rem] leading-8 text-white/72 md:text-[1.04rem]">
                        Our workshops are built to give students clear concept teaching, live practical execution, mentor support during the session, and useful resources they can continue with after the class ends.
                    </p>

                    <div class="mt-9 flex flex-wrap gap-4">
                        <a href="#ongoing-workshops" class="cta-button inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-primary">
                            Explore Live Workshops
                            <span class="material-symbols-outlined text-[18px]">arrow_outward</span>
                        </a>
                        <a href="{{ route('home.contact', ['topic' => 'workshop']) }}" class="cta-button inline-flex items-center gap-2 rounded-2xl border border-white/14 bg-white/10 px-6 py-4 text-sm font-bold text-white backdrop-blur-sm">
                            Request A Seat
                            <span class="material-symbols-outlined text-[18px]">event_available</span>
                        </a>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        @foreach ($heroStats as $stat)
                            <div class="hero-badge-pill reveal rounded-[1.6rem] p-4 {{ $loop->iteration > 1 ? 'stagger-' . $loop->iteration : '' }}">
                                <p class="font-headline text-3xl font-extrabold text-white">{{ $stat['value'] }}</p>
                                <p class="mt-3 text-sm leading-6 text-white/60">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hero-stage reveal">
                    <div class="hero-stage-grid"></div>

                    <div class="hero-stage-card primary">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/54">Live Session Environment</p>
                        <div class="hero-stage-screen mt-4 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-headline text-xl font-extrabold text-white">Workshop Control Deck</p>
                                    <p class="mt-1 text-sm text-white/56">A premium workshop page that clearly shows what learners get inside each session</p>
                                </div>
                                <span class="rounded-full border border-white/12 bg-white/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-[#ead9ff]">Live</span>
                            </div>
                            <div class="mt-6 space-y-3">
                                <div class="hero-stage-line w-[84%]"></div>
                                <div class="hero-stage-line w-[58%]"></div>
                                <div class="hero-stage-line w-[72%]"></div>
                            </div>
                            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                                <div class="hero-stage-chip rounded-2xl p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/48">Focus</p>
                                    <p class="mt-3 text-sm font-semibold text-white">Concept explanation, guided build, and live mentor support.</p>
                                </div>
                                <div class="hero-stage-chip rounded-2xl p-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/48">Includes</p>
                                    <p class="mt-3 text-sm font-semibold text-white">Practice tasks, notes, resources, and doubt solving.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-stage-card secondary animate-float">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/52">What We Provide</p>
                        <p class="mt-3 font-headline text-2xl font-extrabold text-white">Clear teaching. Practical work. Strong mentor guidance.</p>
                    </div>

                    <div class="hero-stage-card tertiary animate-float-delay">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-white/52">Workshop Outcome</p>
                        <p class="mt-3 text-sm leading-7 text-white/76">Students leave each session with better understanding, hands-on practice, and a clear idea of what to do next.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="grid gap-6 lg:grid-cols-[0.96fr_1.04fr]">
                <article class="workshop-panel reveal rounded-[2rem] p-6 md:p-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">What Happens In The Workshop</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">What students get inside every workshop.</h2>
                        <p class="mt-5 max-w-xl text-sm leading-8 text-on-surface-variant md:text-base">
                            Each workshop is designed to be easy to follow, practical to attend, and valuable even after the session is over.
                        </p>

                        <div class="mt-8 grid gap-4">
                            @foreach ($experienceMoments as $moment)
                                <article class="experience-card premium-card overflow-hidden rounded-[1.35rem] {{ $loop->iteration > 1 ? 'reveal stagger-' . min($loop->iteration, 4) : 'reveal' }}">
                                    <div class="experience-card-media">
                                        <img src="{{ $moment['image'] }}" alt="{{ $moment['title'] }}" loading="lazy" />
                                    </div>
                                    <div class="experience-card-body">
                                        <div class="experience-card-heading">
                                            <span class="feature-icon-shell shrink-0">
                                                <span class="material-symbols-outlined text-[22px]">{{ $moment['icon'] }}</span>
                                            </span>
                                            <div class="experience-card-copy">
                                                <h3 class="font-headline text-lg font-bold leading-7 text-on-surface">{{ $moment['title'] }}</h3>
                                                <p class="mt-2 text-sm leading-7 text-on-surface-variant">{{ $moment['description'] }}</p>
                                            </div>
                                        </div>

                                        @if (! empty($moment['points']))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($moment['points'] as $point)
                                                    <span class="experience-point">{{ $point }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </article>

                <article class="section-panel reveal rounded-[2rem] p-6 md:p-8">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Inside The Flow</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Three simple stages in the workshop flow.</h2>

                         
                        <div class="mt-8 overflow-hidden rounded-[1.7rem] bg-[linear-gradient(180deg,rgba(124,58,237,0.08),rgba(255,255,255,0.96))] p-5">
                            <img src="{{ asset('images/live projects.jpeg') }}" alt="Online CodeInYourself workshop session" class="h-56 w-full rounded-[1.3rem] object-cover" />
                        </div>

                        <div class="mt-8 space-y-8">
                            @foreach ($workshopFlow as $flow)
                                <div class="timeline-row">
                                    <span class="timeline-step">{{ $flow['step'] }}</span>
                                    <div class="rounded-[1.55rem] border border-white/70 bg-white/72 p-5 shadow-[0_20px_46px_rgba(124,58,237,0.08)]">
                                        <h3 class="font-headline text-xl font-bold text-on-surface">{{ $flow['title'] }}</h3>
                                        <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $flow['copy'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section id="ongoing-workshops" class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Ongoing And Upcoming Workshops</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Reserve your place in the next live workshop session.</h2>
                </div>
                <p class="max-w-xl text-sm leading-7 text-on-surface-variant">
                    The schedule keeps the most important details easy to scan before registration.
                </p>
            </div>

            @if (session('status'))
                <div class="reveal mt-6 rounded-[1.6rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="reveal mt-6 rounded-[1.6rem] border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-8 grid gap-6 lg:grid-cols-2 2xl:grid-cols-3">
                @forelse ($featuredWorkshops as $workshop)
                    <article class="workshop-list-card reveal {{ $loop->iteration > 1 ? 'stagger-' . min($loop->iteration, 4) : '' }}">
                        <div class="workshop-card-hero bg-gradient-to-r {{ $workshop['accent'] }}">
                            <div class="relative z-10">
                                <div class="flex items-start justify-between gap-4">
                                    <span class="workshop-card-chip inline-flex rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-[#f3e8ff]">{{ $workshop['badge'] }}</span>
                                    <span class="workshop-card-chip inline-flex rounded-full px-3 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-white/84">{{ $workshop['seats'] }}</span>
                                </div>

                                <h3 class="mt-5 font-headline text-[1.85rem] font-extrabold leading-tight md:text-[2rem]">{{ $workshop['title'] }}</h3>
                                <p class="mt-3 max-w-2xl text-sm leading-7 text-white/78">{{ $workshop['subtitle'] }}</p>
                            </div>
                        </div>

                        <div class="workshop-card-body">
                            <div class="workshop-card-summary">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary/72">Workshop Snapshot</p>
                                    <p class="mt-3 text-sm leading-7 text-on-surface-variant">{{ $workshop['subtitle'] }}</p>
                                </div>
                                <div class="workshop-price-badge">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-primary/60">Entry</p>
                                    <p class="font-headline text-2xl font-extrabold text-on-surface">{{ ($workshop['price'] ?? 0) > 0 ? ($workshop['price_label'] ?? (($workshop['currency'] ?? 'INR').' '.($workshop['price'] ?? 0))) : 'Free' }}</p>
                                    <p class="text-xs font-semibold text-on-surface-variant">{{ ($workshop['price'] ?? 0) > 0 ? 'Per learner' : 'Limited seat access' }}</p>
                                </div>
                            </div>

                            <div class="workshop-quick-strip mt-5">
                                <div class="workshop-quick-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Audience</p>
                                    <p class="mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $workshop['audience'] }}</p>
                                </div>
                                <div class="workshop-quick-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Mentor</p>
                                    <p class="mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $workshop['mentor'] }}</p>
                                </div>
                                <div class="workshop-quick-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Seat Window</p>
                                    <p class="mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $workshop['seats'] }}</p>
                                </div>
                            </div>

                            <div class="workshop-meta-grid">
                                <div class="workshop-info-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Date</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $workshop['date'] }}</p>
                                </div>
                                <div class="workshop-info-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Time</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $workshop['time'] }}</p>
                                </div>
                                <div class="workshop-info-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Format</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $workshop['format'] }}</p>
                                </div>
                                <div class="workshop-info-item">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Venue</p>
                                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $workshop['venue'] }}</p>
                                </div>
                            </div>

                            <div class="mt-5 grid flex-1 gap-5">
                                <div>
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Workshop Highlights</p>
                                    <div class="workshop-highlight-list mt-3">
                                        @foreach ($workshop['highlights'] as $highlight)
                                            <div class="workshop-highlight-item">
                                                <span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-primary shadow-[0_0_14px_rgba(124,58,237,0.36)]"></span>
                                                <span class="text-sm font-medium leading-6">{{ $highlight }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="workshop-side-panel">
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Best For</p>
                                            <p class="mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $workshop['audience'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Session Lead</p>
                                            <p class="mt-2 text-sm font-semibold leading-6 text-on-surface">{{ $workshop['mentor'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-2">
                                <button
                                    type="button"
                                    class="cta-button inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#7c3aed_0%,#a855f7_100%)] px-5 py-4 text-sm font-bold text-white shadow-[0_18px_40px_rgba(124,58,237,0.24)]"
                                    data-workshop-join-open
                                    data-workshop='@json($workshop)'
                                >
                                    Reserve My Seat
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="workshop-panel col-span-full rounded-[2rem] p-8 text-center">
                        <div class="relative z-10">
                            <h3 class="font-headline text-3xl font-extrabold text-on-surface">There are no current workshops going on right now.</h3>
                            <p class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-on-surface-variant">
                                New workshop schedules will be announced soon. Please check back later or contact us to get notified.
                            </p>
                            <a href="{{ route('home.contact', ['topic' => 'workshop']) }}" class="cta-button mt-6 inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-bold text-white">
                                <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                                Notify Me
                            </a>
                        </div>
                    </article>
                @endforelse
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Past Workshops</p>
                    <h2 class="mt-3 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">Past workshops with cleaner visual cards.</h2>
                </div>
                <p class="max-w-xl text-sm leading-7 text-on-surface-variant">
                    Each card keeps the preview short, while the details modal still shows the full workshop story.
                </p>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                @foreach ($pastWorkshops as $workshop)
                    <article class="past-card premium-card reveal overflow-hidden rounded-[2rem] {{ $loop->iteration > 1 ? 'stagger-' . min($loop->iteration, 4) : '' }}">
                        <div class="past-cover">
                            <img src="{{ $workshop['cover'] }}" alt="{{ $workshop['title'] }} workshop cover" class="h-full w-full object-cover opacity-84 mix-blend-screen" />
                            <div class="absolute inset-x-0 bottom-0 z-10 p-5 text-white">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/60">{{ $workshop['date'] }}</p>
                                <h3 class="mt-3 font-headline text-2xl font-extrabold">{{ $workshop['title'] }}</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="inline-flex rounded-full border border-primary/12 bg-primary/8 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-primary/78">
                                {{ $workshop['attendees'] }}
                            </div>
                            <p class="mt-4 text-sm leading-7 text-on-surface-variant">{{ $workshop['summary'] }}</p>

                            <button
                                type="button"
                                class="cta-button mt-6 inline-flex items-center gap-2 rounded-2xl bg-primary px-5 py-3 text-sm font-bold text-white"
                                data-workshop-modal-open
                                data-workshop='@json($workshop)'
                            >
                                View Details
                                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6">
            <div class="section-panel reveal overflow-hidden rounded-[2rem] p-6 md:p-8">
                <div class="relative z-10 grid gap-8 lg:grid-cols-[1.02fr_0.98fr] lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Final Call</p>
                        <h2 class="mt-4 font-headline text-3xl font-extrabold text-on-surface md:text-4xl">A cleaner workshop page that feels more premium and easier to scan.</h2>
                        <p class="mt-5 max-w-2xl text-sm leading-8 text-on-surface-variant md:text-base">
                            The layout now balances strong visuals, short copy, and quick access to registration.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @if (!empty($featuredWorkshops))
                            <button type="button" class="cta-button inline-flex items-center justify-center gap-2 rounded-[1.5rem] bg-primary px-6 py-5 text-sm font-bold text-white" data-workshop-join-open data-workshop='@json($featuredWorkshops[0])'>
                                Join Next Workshop
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
                        @else
                            <a href="{{ route('home.contact', ['topic' => 'workshop']) }}" class="cta-button inline-flex items-center justify-center gap-2 rounded-[1.5rem] bg-primary px-6 py-5 text-sm font-bold text-white">
                                Request Workshop Update
                                <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                            </a>
                        @endif
                        <a href="{{ route('home.contact') }}" class="cta-button inline-flex items-center justify-center gap-2 rounded-[1.5rem] border border-primary/12 bg-white px-6 py-5 text-sm font-bold text-primary">
                            Talk To Our Team
                            <span class="material-symbols-outlined text-[18px]">support_agent</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div id="workshop-detail-modal" class="detail-modal" aria-hidden="true">
            <div class="detail-modal-panel pretty-scroll">
                <div class="sticky top-0 z-20 flex items-center justify-between border-b border-[#ebdef7] bg-white/88 px-5 py-4 backdrop-blur-xl md:px-8">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/70">Past Workshop Details</p>
                        <h3 id="detail-title" class="mt-2 font-headline text-2xl font-extrabold text-on-surface"></h3>
                    </div>
                    <button type="button" id="workshop-detail-close" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-primary/12 bg-white text-primary shadow-[0_12px_30px_rgba(124,58,237,0.12)]">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="px-5 py-6 md:px-8 md:py-8">
                    <div class="detail-cover mb-6">
                        <img id="detail-cover-image" src="" alt="" class="h-full w-full object-cover mix-blend-screen opacity-90" />
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 text-white md:p-8">
                            <p id="detail-focus" class="max-w-2xl text-sm leading-7 text-white/78"></p>
                            <div class="mt-5 flex flex-wrap gap-3">
                                <span id="detail-date-chip" class="detail-stat-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.2em]"></span>
                                <span id="detail-attendees-chip" class="detail-stat-chip rounded-full px-4 py-2 text-[11px] font-bold uppercase tracking-[0.2em]"></span>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
                        <div>
                            <div class="mb-6 rounded-[1.6rem] border border-[#eadcf8] bg-white/82 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/72">Workshop Snapshot</p>
                                <p id="detail-summary" class="mt-4 text-sm leading-7 text-on-surface-variant"></p>
                            </div>
                            <div id="detail-gallery" class="detail-gallery"></div>
                        </div>

                        <div class="space-y-6">
                            <div class="rounded-[1.6rem] border border-[#eadcf8] bg-white/82 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/72">Session Summary</p>
                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-[1.2rem] border border-[#f0e7fb] bg-[#fcf9ff] px-4 py-3">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Date</p>
                                        <p id="detail-date" class="mt-2 text-sm font-semibold text-on-surface"></p>
                                    </div>
                                    <div class="rounded-[1.2rem] border border-[#f0e7fb] bg-[#fcf9ff] px-4 py-3">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">Participants</p>
                                        <p id="detail-attendees" class="mt-2 text-sm font-semibold text-on-surface"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[1.6rem] border border-[#eadcf8] bg-white/82 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/72">Tasks Done In Session</p>
                                <div id="detail-tasks" class="mt-4 space-y-3"></div>
                            </div>

                            <div class="rounded-[1.6rem] border border-[#eadcf8] bg-white/82 p-5">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-primary/72">Key Outcomes</p>
                                <div id="detail-outcomes" class="mt-4 space-y-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="workshop-join-modal" class="detail-modal" aria-hidden="true">
            <div class="detail-modal-panel join-modal-panel pretty-scroll">
                <div class="join-modal-grid grid lg:grid-cols-[0.92fr_1.08fr]">
                    <div class="join-hero-pane relative p-6 text-white md:p-8">
                        <div class="relative z-10">
                            <button type="button" id="workshop-join-close" class="absolute right-0 top-0 inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/14 bg-white/10 text-white backdrop-blur-md">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>

                            <span class="inline-flex items-center gap-2 rounded-full border border-white/14 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] text-white/78">
                                <span class="h-2 w-2 rounded-full bg-[#e9d5ff]"></span>
                                Workshop Registration
                            </span>

                            <h3 id="join-workshop-title" class="mt-8 max-w-xl font-headline text-3xl font-extrabold leading-tight md:text-4xl"></h3>
                            <p id="join-workshop-subtitle" class="mt-4 max-w-xl text-sm leading-8 text-white/74"></p>

                            <div class="join-meta-grid mt-8">
                                <div class="detail-stat-chip rounded-[1.25rem] px-4 py-3 text-sm font-semibold text-white/84">Date: <span id="join-workshop-date" class="font-bold text-white"></span></div>
                                <div class="detail-stat-chip rounded-[1.25rem] px-4 py-3 text-sm font-semibold text-white/84">Time: <span id="join-workshop-time" class="font-bold text-white"></span></div>
                                <div class="detail-stat-chip rounded-[1.25rem] px-4 py-3 text-sm font-semibold text-white/84">Format: <span id="join-workshop-format" class="font-bold text-white"></span></div>
                                <div class="detail-stat-chip rounded-[1.25rem] px-4 py-3 text-sm font-semibold text-white/84">Venue: <span id="join-workshop-venue" class="font-bold text-white"></span></div>
                            </div>
                        </div>

                        <div class="join-side-card mt-8 rounded-[1.7rem] p-5 md:p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-white/52">How It Works</p>
                            <div class="join-side-list mt-4">
                                <div class="join-side-list-item">
                                    <span></span>
                                    <span>Fill in your details so the team can reserve your seat for the selected workshop.</span>
                                </div>
                                <div class="join-side-list-item">
                                    <span></span>
                                    <span>Share your learning goal, attendance preference, and any notes you want the team to know.</span>
                                </div>
                                <div class="join-side-list-item">
                                    <span></span>
                                    <span>Our team will review the request and reach out with the next update for your registration.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="join-form-pane bg-[linear-gradient(180deg,rgba(255,255,255,0.98),rgba(248,243,255,0.94))] p-6 md:p-8">
                        <div class="join-form-card rounded-[1.8rem] p-5 md:p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">Student Details</p>
                            <h3 class="mt-3 font-headline text-3xl font-extrabold text-on-surface">Request your workshop seat.</h3>
                            <p class="mt-3 text-sm leading-7 text-on-surface-variant">Share the essential details below. Free workshops submit instantly, and paid workshops will open Razorpay checkout after this form is complete.</p>

                            <form action="{{ route('home.workshop.register') }}" method="POST" class="mt-6 space-y-5" id="workshop-join-form">
                                @csrf
                                <input type="hidden" name="workshop_id" id="join-form-workshop-id" value="{{ old('workshop_id') }}" />
                                <input type="hidden" name="workshop_title" id="join-form-workshop-title" value="{{ old('workshop_title') }}" />
                                <input type="hidden" name="workshop_date" id="join-form-workshop-date" value="{{ old('workshop_date') }}" />
                                <input type="hidden" name="workshop_time" id="join-form-workshop-time" value="{{ old('workshop_time') }}" />
                                <input type="hidden" name="razorpay_payment_id" id="join-form-razorpay-payment-id" value="" />
                                <input type="hidden" name="razorpay_order_id" id="join-form-razorpay-order-id" value="" />
                                <input type="hidden" name="razorpay_signature" id="join-form-razorpay-signature" value="" />

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="field-label">Full Name</label>
                                        <div class="field-shell">
                                            <input class="premium-input" type="text" name="name" placeholder="Your full name" value="{{ old('name') }}" required />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label">Email Address</label>
                                        <div class="field-shell">
                                            <input class="premium-input" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="field-label">Phone Number</label>
                                        <div class="field-shell">
                                            <input class="premium-input" type="tel" name="phone" placeholder="+91 98765 43210" value="{{ old('phone') }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label">City</label>
                                        <div class="field-shell">
                                            <input class="premium-input" type="text" name="city" placeholder="Your city" value="{{ old('city') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="field-label">College Or Company</label>
                                        <div class="field-shell">
                                            <input class="premium-input" type="text" name="organization" placeholder="College / company name" value="{{ old('organization') }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label">Learner Type</label>
                                        <div class="field-shell">
                                            <select class="premium-select" name="learner_type">
                                                <option value="">Select learner type</option>
                                                <option value="School Student" @selected(old('learner_type') === 'School Student')>School Student</option>
                                                <option value="College Student" @selected(old('learner_type') === 'College Student')>College Student</option>
                                                <option value="Fresher" @selected(old('learner_type') === 'Fresher')>Fresher</option>
                                                <option value="Working Professional" @selected(old('learner_type') === 'Working Professional')>Working Professional</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="field-label">Experience Level</label>
                                        <div class="field-shell">
                                            <select class="premium-select" name="experience_level">
                                                <option value="">Select experience level</option>
                                                <option value="Beginner" @selected(old('experience_level') === 'Beginner')>Beginner</option>
                                                <option value="Intermediate" @selected(old('experience_level') === 'Intermediate')>Intermediate</option>
                                                <option value="Advanced" @selected(old('experience_level') === 'Advanced')>Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="field-label">Preferred Attendance</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="mode-option">
                                                <input type="radio" name="attendance_mode" value="Online" @checked(old('attendance_mode', 'Online') === 'Online') />
                                                <span>Online</span>
                                            </label>
                                            <label class="mode-option">
                                                <input type="radio" name="attendance_mode" value="Offline" @checked(old('attendance_mode') === 'Offline') />
                                                <span>Offline</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="field-label">What Do You Want From This Workshop</label>
                                    <div class="field-shell">
                                        <textarea class="premium-textarea" name="goals" placeholder="Tell us your goal, like learning a tool, building confidence, interview prep, or project guidance.">{{ old('goals') }}</textarea>
                                    </div>
                                </div>

                                <div>
                                    <label class="field-label">Questions Or Notes</label>
                                    <div class="field-shell">
                                        <textarea class="premium-textarea" name="questions" placeholder="Any special question, offline seat request, or help you need before joining?">{{ old('questions') }}</textarea>
                                    </div>
                                </div>

                                <div id="join-payment-summary" class="hidden rounded-[1.4rem] border border-primary/12 bg-[linear-gradient(180deg,rgba(124,58,237,0.08),rgba(255,255,255,0.98))] px-4 py-4">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                        <div>
                                            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-primary/72">Workshop Payment</p>
                                            <p id="join-payment-summary-copy" class="mt-2 text-sm font-semibold text-on-surface"></p>
                                        </div>
                                        <span id="join-payment-summary-amount" class="rounded-full bg-primary px-4 py-2 text-sm font-bold text-white"></span>
                                    </div>
                                </div>

                                <button type="submit" id="join-submit-button" class="cta-button inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-[linear-gradient(135deg,#6d28d9_0%,#8b5cf6_52%,#c084fc_100%)] px-6 py-4 text-sm font-bold text-white shadow-[0_18px_40px_rgb(98_24_233_/_48%)]">
                                    <span id="join-submit-label">Submit Seat Request</span>
                                    <span class="material-symbols-outlined text-[20px]">trending_flat</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="workshop-join-bootstrap"
            class="hidden"
            data-should-open="{{ ($errors->any() || session('status')) ? '1' : '0' }}"
            data-id="{{ old('workshop_id', $featuredWorkshops[0]['id'] ?? '') }}"
            data-title="{{ old('workshop_title', $featuredWorkshops[0]['title'] ?? 'Workshop Registration') }}"
            data-subtitle="Fill in your details to request your seat and our team will follow up with the next step."
            data-date="{{ old('workshop_date', $featuredWorkshops[0]['date'] ?? '') }}"
            data-time="{{ old('workshop_time', $featuredWorkshops[0]['time'] ?? '') }}"
            data-format="{{ $featuredWorkshops[0]['format'] ?? '' }}"
            data-venue="{{ $featuredWorkshops[0]['venue'] ?? '' }}"
            data-price="{{ old('payment_amount', $featuredWorkshops[0]['price'] ?? 0) }}"
            data-price-label="{{ $featuredWorkshops[0]['price_label'] ?? 'Free' }}"
            data-register-url="{{ route('home.workshop.register') }}"
            data-payment-order-url="{{ route('home.workshop.payment-order') }}"
            data-payment-verify-url="{{ route('home.workshop.verify-payment') }}"
            data-razorpay-enabled="{{ $workshopRazorpayConfigured ? '1' : '0' }}"
        ></div>
    </main>

    <x-slot:scripts>
        @if ($workshopRazorpayConfigured)
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        @endif
        <script>
            (function () {
                var modal = document.getElementById('workshop-detail-modal');
                var joinModal = document.getElementById('workshop-join-modal');
                var closeButton = document.getElementById('workshop-detail-close');
                var joinCloseButton = document.getElementById('workshop-join-close');
                var title = document.getElementById('detail-title');
                var date = document.getElementById('detail-date');
                var attendees = document.getElementById('detail-attendees');
                var summary = document.getElementById('detail-summary');
                var focus = document.getElementById('detail-focus');
                var coverImage = document.getElementById('detail-cover-image');
                var dateChip = document.getElementById('detail-date-chip');
                var attendeesChip = document.getElementById('detail-attendees-chip');
                var gallery = document.getElementById('detail-gallery');
                var tasks = document.getElementById('detail-tasks');
                var outcomes = document.getElementById('detail-outcomes');
                var joinTitle = document.getElementById('join-workshop-title');
                var joinSubtitle = document.getElementById('join-workshop-subtitle');
                var joinDate = document.getElementById('join-workshop-date');
                var joinTime = document.getElementById('join-workshop-time');
                var joinFormat = document.getElementById('join-workshop-format');
                var joinVenue = document.getElementById('join-workshop-venue');
                var joinForm = document.getElementById('workshop-join-form');
                var joinFormTitle = document.getElementById('join-form-workshop-title');
                var joinFormDate = document.getElementById('join-form-workshop-date');
                var joinFormTime = document.getElementById('join-form-workshop-time');
                var joinFormId = document.getElementById('join-form-workshop-id');
                var joinFormRazorpayPaymentId = document.getElementById('join-form-razorpay-payment-id');
                var joinFormRazorpayOrderId = document.getElementById('join-form-razorpay-order-id');
                var joinFormRazorpaySignature = document.getElementById('join-form-razorpay-signature');
                var joinSubmitButton = document.getElementById('join-submit-button');
                var joinSubmitLabel = document.getElementById('join-submit-label');
                var joinPaymentSummary = document.getElementById('join-payment-summary');
                var joinPaymentSummaryCopy = document.getElementById('join-payment-summary-copy');
                var joinPaymentSummaryAmount = document.getElementById('join-payment-summary-amount');
                var joinBootstrap = document.getElementById('workshop-join-bootstrap');
                var joinModalPanel = joinModal ? joinModal.querySelector('.detail-modal-panel') : null;
                var currentJoinPayload = null;

                function toggleBodyLock(isLocked) {
                    document.body.style.overflow = isLocked ? 'hidden' : '';
                }

                function renderList(target, items) {
                    target.innerHTML = '';
                    items.forEach(function (item) {
                        var row = document.createElement('div');
                        row.className = 'flex items-start gap-3 rounded-[1.2rem] border border-[#f0e7fb] bg-[#fcf9ff] px-4 py-3 text-sm leading-7 text-on-surface-variant';
                        row.innerHTML = '<span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-primary"></span><span>' + item + '</span>';
                        target.appendChild(row);
                    });
                }

                function renderGallery(images, altBase) {
                    gallery.innerHTML = '';
                    images.forEach(function (src, index) {
                        var img = document.createElement('img');
                        img.src = src;
                        img.alt = altBase + ' image ' + (index + 1);
                        img.loading = 'lazy';
                        gallery.appendChild(img);
                    });
                }

                function openModal(payload) {
                    title.textContent = payload.title || '';
                    date.textContent = payload.date || '';
                    attendees.textContent = payload.attendees || '';
                    summary.textContent = payload.summary || '';
                    focus.textContent = payload.focus || '';
                    coverImage.src = payload.cover || '';
                    coverImage.alt = (payload.title || 'Workshop') + ' cover image';
                    dateChip.textContent = payload.date || '';
                    attendeesChip.textContent = payload.attendees || '';
                    renderGallery(payload.gallery || [], payload.title || 'Workshop');
                    renderList(tasks, payload.tasks || []);
                    renderList(outcomes, payload.outcomes || []);
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    toggleBodyLock(true);
                }

                function closeModal() {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    toggleBodyLock(false);
                }

                function syncJoinPaymentState(payload) {
                    var price = Number(payload && payload.price ? payload.price : 0);
                    var isPaidWorkshop = price > 0;

                    if (joinPaymentSummary) {
                        joinPaymentSummary.classList.toggle('hidden', !isPaidWorkshop);
                    }

                    if (joinPaymentSummaryCopy) {
                        joinPaymentSummaryCopy.textContent = isPaidWorkshop
                            ? 'You will be redirected to Razorpay checkout after validating this form.'
                            : 'No online payment is required. We will receive your seat request immediately.';
                    }

                    if (joinPaymentSummaryAmount) {
                        joinPaymentSummaryAmount.textContent = isPaidWorkshop
                            ? (payload.price_label || payload.currency + ' ' + price)
                            : 'Free';
                    }

                    if (joinSubmitLabel) {
                        joinSubmitLabel.textContent = isPaidWorkshop ? 'Pay & Reserve Seat' : 'Submit Seat Request';
                    }
                }

                function openJoinModal(payload) {
                    currentJoinPayload = payload || {};
                    joinTitle.textContent = payload.title || '';
                    joinSubtitle.textContent = payload.subtitle || '';
                    joinDate.textContent = payload.date || '';
                    joinTime.textContent = payload.time || '';
                    joinFormat.textContent = payload.format || '';
                    joinVenue.textContent = payload.venue || '';
                    joinFormTitle.value = payload.title || '';
                    joinFormDate.value = payload.date || '';
                    joinFormTime.value = payload.time || '';
                    joinFormId.value = payload.id || '';
                    if (joinForm) {
                        joinForm.action = joinBootstrap.dataset.registerUrl;
                    }
                    if (joinFormRazorpayPaymentId) {
                        joinFormRazorpayPaymentId.value = '';
                    }
                    if (joinFormRazorpayOrderId) {
                        joinFormRazorpayOrderId.value = '';
                    }
                    if (joinFormRazorpaySignature) {
                        joinFormRazorpaySignature.value = '';
                    }
                    if (joinSubmitButton) {
                        joinSubmitButton.disabled = false;
                        joinSubmitButton.classList.remove('opacity-70');
                    }
                    syncJoinPaymentState(payload || {});
                    joinModal.classList.add('is-open');
                    joinModal.setAttribute('aria-hidden', 'false');
                    toggleBodyLock(true);
                    if (joinModalPanel) {
                        joinModalPanel.scrollTop = 0;
                    }
                }

                function closeJoinModal() {
                    joinModal.classList.remove('is-open');
                    joinModal.setAttribute('aria-hidden', 'true');
                    toggleBodyLock(false);
                }

                document.querySelectorAll('[data-workshop-modal-open]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        try {
                            var payload = JSON.parse(button.getAttribute('data-workshop') || '{}');
                            openModal(payload);
                        } catch (error) {
                            console.error('Unable to open workshop detail modal', error);
                        }
                    });
                });

                document.querySelectorAll('[data-workshop-join-open]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        try {
                            var payload = JSON.parse(button.getAttribute('data-workshop') || '{}');
                            openJoinModal(payload);
                        } catch (error) {
                            console.error('Unable to open workshop join modal', error);
                        }
                    });
                });

                if (closeButton) {
                    closeButton.addEventListener('click', closeModal);
                }

                if (joinCloseButton) {
                    joinCloseButton.addEventListener('click', closeJoinModal);
                }

                if (modal) {
                    modal.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            closeModal();
                        }
                    });
                }

                if (joinModal) {
                    joinModal.addEventListener('click', function (event) {
                        if (event.target === joinModal) {
                            closeJoinModal();
                        }
                    });
                }

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && modal && modal.classList.contains('is-open')) {
                        closeModal();
                    }

                    if (event.key === 'Escape' && joinModal && joinModal.classList.contains('is-open')) {
                        closeJoinModal();
                    }
                });

                if (joinForm) {
                    joinForm.addEventListener('submit', function (event) {
                        var price = Number(currentJoinPayload && currentJoinPayload.price ? currentJoinPayload.price : 0);
                        var razorpayEnabled = joinBootstrap && joinBootstrap.dataset.razorpayEnabled === '1';

                        if (price <= 0) {
                            joinForm.action = joinBootstrap.dataset.registerUrl;
                            return;
                        }

                        if (!razorpayEnabled || typeof Razorpay === 'undefined') {
                            event.preventDefault();
                            window.alert('Razorpay is not configured right now. Please try again later.');
                            return;
                        }

                        event.preventDefault();

                        if (joinSubmitButton) {
                            joinSubmitButton.disabled = true;
                            joinSubmitButton.classList.add('opacity-70');
                        }

                        var formData = new FormData(joinForm);

                        fetch(joinBootstrap.dataset.paymentOrderUrl, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': formData.get('_token'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                            .then(function (response) {
                                return response.json().then(function (data) {
                                    if (!response.ok) {
                                        throw new Error(data.message || 'Unable to start workshop payment right now.');
                                    }

                                    return data;
                                });
                            })
                            .then(function (payload) {
                                var razorpay = new Razorpay({
                                    key: payload.key,
                                    amount: Number(payload.amount || 0),
                                    currency: payload.currency || 'INR',
                                    name: 'CodeInYourself',
                                    description: payload.workshop && payload.workshop.title ? payload.workshop.title : 'Workshop registration',
                                    order_id: payload.order.id,
                                    handler: function (response) {
                                        joinFormRazorpayPaymentId.value = response.razorpay_payment_id || '';
                                        joinFormRazorpayOrderId.value = response.razorpay_order_id || '';
                                        joinFormRazorpaySignature.value = response.razorpay_signature || '';
                                        joinForm.action = joinBootstrap.dataset.paymentVerifyUrl;
                                        joinForm.submit();
                                    },
                                    prefill: {
                                        name: payload.customer && payload.customer.name ? payload.customer.name : '',
                                        email: payload.customer && payload.customer.email ? payload.customer.email : '',
                                        contact: payload.customer && payload.customer.contact ? payload.customer.contact : ''
                                    },
                                    theme: {
                                        color: '#7c3aed'
                                    },
                                    modal: {
                                        ondismiss: function () {
                                            if (joinSubmitButton) {
                                                joinSubmitButton.disabled = false;
                                                joinSubmitButton.classList.remove('opacity-70');
                                            }
                                        }
                                    }
                                });

                                razorpay.open();
                            })
                            .catch(function (error) {
                                window.alert(error.message || 'Unable to start workshop payment right now.');
                                if (joinSubmitButton) {
                                    joinSubmitButton.disabled = false;
                                    joinSubmitButton.classList.remove('opacity-70');
                                }
                            });
                    });
                }

                if (joinBootstrap && joinBootstrap.dataset.shouldOpen === '1') {
                    openJoinModal({
                        id: joinBootstrap.dataset.id || '',
                        title: joinBootstrap.dataset.title || 'Workshop Registration',
                        subtitle: joinBootstrap.dataset.subtitle || '',
                        date: joinBootstrap.dataset.date || '',
                        time: joinBootstrap.dataset.time || '',
                        format: joinBootstrap.dataset.format || '',
                        venue: joinBootstrap.dataset.venue || '',
                        price: joinBootstrap.dataset.price || '0',
                        price_label: joinBootstrap.dataset.priceLabel || 'Free'
                    });
                }
            })();
        </script>
    </x-slot:scripts>
</x-home.marketing-layout>
