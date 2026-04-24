@php($workshopCount = method_exists($workshops, 'total') ? $workshops->total() : $workshops->count())
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manage Workshops | HR Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body { font-family: Inter, sans-serif; }
        h1, h2, h3, .font-headline { font-family: Manrope, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .panel { border: 1px solid rgba(226,232,240,0.92); border-radius: 1.7rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.98)); box-shadow: 0 18px 42px rgba(15,23,42,0.06); }
        .field-shell { border: 1px solid rgba(214,228,240,0.94); border-radius: 1.45rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(246,250,253,0.96)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.92), 0 12px 26px rgba(15,23,42,0.035); }
        .field-label { display: block; margin-bottom: 0.5rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(13 148 136); }
        .field-hint { margin-top: 0.55rem; font-size: 0.78rem; line-height: 1.45; color: rgb(100 116 139); }
        .field-input, .field-textarea, .field-select { width: 100%; border-radius: 1rem; border: 1px solid transparent; background: rgba(255,255,255,0.92); color: rgb(15 23 42); box-shadow: inset 0 0 0 1px rgba(148,163,184,0.18); min-height: 3.2rem; padding: 0.95rem 1rem; }
        .field-textarea { min-height: 8rem; resize: vertical; }
        .field-input:focus, .field-textarea:focus, .field-select:focus { outline: none; background: #fff; border-color: rgba(13,148,136,0.22); box-shadow: 0 0 0 4px rgba(13,148,136,0.08), inset 0 0 0 1px rgba(13,148,136,0.12); }
        .hero-card { border: 1px solid rgba(255,255,255,0.14); background: rgba(255,255,255,0.10); backdrop-filter: blur(14px); }
        .toggle-card { display: flex; gap: 0.9rem; align-items: flex-start; border: 1px solid rgba(226,232,240,0.9); border-radius: 1.35rem; background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.95)); padding: 1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,0.9); }
        .toggle-card input { margin-top: 0.2rem; height: 1rem; width: 1rem; accent-color: rgb(13 148 136); }
        .table-shell { border: 1px solid rgba(226,232,240,0.9); border-radius: 1.55rem; overflow: hidden; background: rgba(255,255,255,0.92); }
        .inventory-table { width: 100%; min-width: 960px; border-collapse: collapse; }
        .inventory-table th { background: rgba(241,245,249,0.92); padding: 1rem 1.1rem; text-align: left; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; color: rgb(71 85 105); }
        .inventory-table td { padding: 1rem 1.1rem; vertical-align: top; border-top: 1px solid rgba(226,232,240,0.92); font-size: 0.92rem; color: rgb(15 23 42); }
        .status-pill { display: inline-flex; align-items: center; gap: 0.45rem; border-radius: 999px; padding: 0.45rem 0.85rem; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.14em; text-transform: uppercase; }
        .table-chip { display: inline-flex; border-radius: 999px; padding: 0.45rem 0.8rem; font-size: 0.72rem; font-weight: 700; }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(94,234,212,0.16),_transparent_18%),linear-gradient(180deg,#f8fbff_0%,#eef6ff_100%)] text-slate-900">
<x-hr.navbar />
<main class="px-4 py-8 md:ml-64 md:px-8">
    <div class="mx-auto max-w-7xl space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
        @endif

        <section class="overflow-hidden rounded-[2.2rem] bg-[linear-gradient(135deg,#042f2e_0%,#115e59_38%,#0f766e_62%,#5eead4_100%)] px-6 py-8 text-white shadow-[0_30px_90px_rgba(15,118,110,0.20)] md:px-8 md:py-10">
            <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr] xl:items-end">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-teal-100/80">Workshop Control Room</p>
                    <h1 class="mt-4 max-w-3xl font-headline text-3xl font-extrabold leading-tight md:text-5xl">
                        {{ $editingWorkshop ? 'Refine the current workshop posting.' : 'Create cleaner workshop listings for the public page.' }}
                    </h1>
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-teal-50/86 md:text-base">
                        Organize workshop content, schedule details, pricing, payment setup, and visibility from one cleaner management screen.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="hero-card rounded-[1.5rem] p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Pending</p>
                        <p class="mt-3 text-2xl font-extrabold text-white">{{ $registrationCounts['pending'] ?? 0 }}</p>
                        <p class="mt-2 text-sm text-teal-50/78">Waiting for team review</p>
                    </div>
                    <div class="hero-card rounded-[1.5rem] p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Confirmed</p>
                        <p class="mt-3 text-2xl font-extrabold text-white">{{ $registrationCounts['confirmed'] ?? 0 }}</p>
                        <p class="mt-2 text-sm text-teal-50/78">Approved registrations</p>
                    </div>
                    <div class="hero-card rounded-[1.5rem] p-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-teal-100/70">Payments Desk</p>
                        <a class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-white underline decoration-white/40 underline-offset-4" href="{{ route('hr.workshop-registrations') }}">
                            Open review page
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <p class="mt-2 text-sm text-teal-50/78">Track approvals and follow-ups</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-8">
            <div class="panel p-6 md:p-7">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-700">{{ $editingWorkshop ? 'Edit Workshop' : 'Create Workshop' }}</p>
                        <h2 class="mt-2 font-headline text-3xl font-extrabold text-slate-900">{{ $editingWorkshop ? 'Update workshop posting' : 'Build a polished workshop card' }}</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-500">Keep the content short, clear, and easy to scan so the public page feels stronger.</p>
                    </div>
                    @if ($editingWorkshop)
                        <a class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.workshops') }}">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            Cancel edit
                        </a>
                    @endif
                </div>

                <form action="{{ $editingWorkshop ? route('hr.workshops.update', $editingWorkshop) : route('hr.workshops.store') }}" class="mt-7 space-y-6" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($editingWorkshop)
                        @method('PUT')
                    @endif

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell">
                            <label class="field-label">Badge</label>
                            <input class="field-input" name="badge" type="text" value="{{ old('badge', $editingWorkshop->badge ?? '') }}" placeholder="Upcoming, Bestseller, Weekend Batch" />
                            <p class="field-hint">Short label shown on the card top.</p>
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Workshop Title</label>
                            <input class="field-input" name="title" type="text" value="{{ old('title', $editingWorkshop->title ?? '') }}" placeholder="Generative AI Build Lab" />
                            <p class="field-hint">Use a strong outcome-focused workshop name.</p>
                        </div>

                        <div class="field-shell lg:col-span-2">
                            <label class="field-label">Subtitle</label>
                            <textarea class="field-textarea" name="subtitle" rows="3" placeholder="Briefly describe what students will learn and why this session matters.">{{ old('subtitle', $editingWorkshop->subtitle ?? '') }}</textarea>
                        </div>

                        <div class="field-shell">
                            <label class="field-label">Date</label>
                            <input class="field-input" name="date_label" type="text" value="{{ old('date_label', $editingWorkshop->date_label ?? '') }}" placeholder="May 3, 2026" />
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Time</label>
                            <input class="field-input" name="time_label" type="text" value="{{ old('time_label', $editingWorkshop->time_label ?? '') }}" placeholder="7:00 PM to 9:30 PM IST" />
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Format</label>
                            <input class="field-input" name="format" type="text" value="{{ old('format', $editingWorkshop->format ?? '') }}" placeholder="Live online intensive" />
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Venue</label>
                            <input class="field-input" name="venue" type="text" value="{{ old('venue', $editingWorkshop->venue ?? '') }}" placeholder="Online live studio" />
                        </div>
                    </div>

                    <div class="panel border-slate-200/80 bg-slate-50/70 p-5">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-teal-700">Audience And Presentation</p>
                                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Shape the workshop card details</h3>
                            </div>
                            <div class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Public card essentials</div>
                        </div>

                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            <div class="field-shell">
                                <label class="field-label">Audience</label>
                                <input class="field-input" name="audience" type="text" value="{{ old('audience', $editingWorkshop->audience ?? '') }}" placeholder="Students, freshers, and working professionals" />
                            </div>
                            <div class="field-shell">
                                <label class="field-label">Mentor</label>
                                <input class="field-input" name="mentor" type="text" value="{{ old('mentor', $editingWorkshop->mentor ?? '') }}" placeholder="Lead AI mentor panel" />
                            </div>
                            <div class="field-shell">
                                <label class="field-label">Seats Text</label>
                                <input class="field-input" name="seats" type="text" value="{{ old('seats', $editingWorkshop->seats ?? '') }}" placeholder="38 seats left" />
                            </div>
                            <div class="field-shell">
                                <label class="field-label">Highlights</label>
                                <textarea class="field-textarea" name="highlights" rows="5" placeholder="One highlight per line">{{ old('highlights', isset($editingWorkshop) ? implode(PHP_EOL, $editingWorkshop->highlights ?? []) : '') }}</textarea>
                                <p class="field-hint">Each line becomes a separate highlight chip on the public page.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="field-shell">
                            <label class="field-label">Price</label>
                            <input class="field-input" name="price" type="number" min="0" step="0.01" value="{{ old('price', $editingWorkshop->price ?? 0) }}" />
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Currency</label>
                            <input class="field-input" name="currency" type="text" value="{{ old('currency', $editingWorkshop->currency ?? 'INR') }}" />
                        </div>
                        <div class="field-shell">
                            <label class="field-label">Sort Order</label>
                            <input class="field-input" name="sort_order" type="number" value="{{ old('sort_order', $editingWorkshop->sort_order ?? 0) }}" />
                        </div>
                    </div>

                    <div class="panel border-slate-200/80 bg-slate-50/70 p-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-teal-700">Payment And Visibility</p>
                            <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Control registration behavior</h3>
                        </div>

                        <div class="mt-5 grid gap-4 lg:grid-cols-2">
                            <label class="toggle-card">
                                <input name="payment_enabled" type="checkbox" value="1" @checked(old('payment_enabled', $editingWorkshop->payment_enabled ?? false)) />
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Enable payment flow</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-500">Turn this on only when the workshop should ask for payment before confirmation.</p>
                                </div>
                            </label>

                            <label class="toggle-card">
                                <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $editingWorkshop->is_active ?? true)) />
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Show on public site</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-500">Hide the workshop card without deleting the workshop content.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button class="inline-flex items-center gap-2 rounded-xl bg-teal-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_14px_28px_rgba(13,148,136,0.22)]" type="submit">
                            <span class="material-symbols-outlined text-[18px]">{{ $editingWorkshop ? 'edit' : 'add_circle' }}</span>
                            {{ $editingWorkshop ? 'Update Workshop' : 'Create Workshop' }}
                        </button>
                        @if ($editingWorkshop)
                            <a class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700" href="{{ route('hr.workshops') }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                Back to list
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <section class="panel p-6 md:p-7" id="workshops-table">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-700">Current Workshops</p>
                        <h2 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">Workshop inventory in table format</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-500">All current workshop entries are shown below the form so they are easier to review, edit, and compare.</p>
                    </div>
                    <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $workshopCount }} items</div>
                </div>

                @if ($workshops->isNotEmpty())
                    <div class="table-shell mt-6 overflow-x-auto">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Workshop</th>
                                    <th>Schedule</th>
                                    <th>Format</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Highlights</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workshops as $workshop)
                                    <tr>
                                        <td>
                                            <div class="max-w-sm">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="table-chip bg-teal-50 text-teal-700">{{ $workshop->badge ?: 'Workshop' }}</span>
                                                </div>
                                                <p class="mt-3 font-headline text-lg font-extrabold text-slate-900">{{ $workshop->title }}</p>
                                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($workshop->subtitle, 120) ?: 'No subtitle added yet.' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="font-semibold text-slate-900">{{ $workshop->date_label ?: 'Not added' }}</p>
                                            <p class="mt-2 text-sm text-slate-500">{{ $workshop->time_label ?: 'Time not added' }}</p>
                                        </td>
                                        <td>
                                            <p class="font-semibold text-slate-900">{{ $workshop->format ?: 'Not added' }}</p>
                                            <p class="mt-2 text-sm text-slate-500">{{ $workshop->venue ?: 'Venue not added' }}</p>
                                        </td>
                                        <td>
                                            <p class="font-semibold text-slate-900">{{ $workshop->currency ?: 'INR' }} {{ number_format((float) ($workshop->price ?? 0), ((float) ($workshop->price ?? 0) === floor((float) ($workshop->price ?? 0))) ? 0 : 2) }}</p>
                                            <p class="mt-2 text-sm {{ $workshop->payment_enabled ? 'text-emerald-600' : 'text-slate-400' }}">{{ $workshop->payment_enabled ? 'Payment enabled' : 'Free / no payment' }}</p>
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $workshop->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $workshop->is_active ? 'Active' : 'Hidden' }}</span>
                                            <p class="mt-3 text-sm text-slate-500">{{ $workshop->audience ?: 'Audience not added' }}</p>
                                        </td>
                                        <td>
                                            <div class="flex max-w-xs flex-wrap gap-2">
                                                @forelse (($workshop->highlights ?? []) as $highlight)
                                                    <span class="table-chip bg-teal-50 text-teal-700">{{ $highlight }}</span>
                                                @empty
                                                    <span class="text-sm text-slate-400">No highlights</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex flex-col gap-2">
                                                <a class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700" href="{{ route('hr.workshops', ['edit' => $workshop->id]) }}">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                    Edit
                                                </a>
                                                <form action="{{ route('hr.workshops.destroy', $workshop) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-600" type="submit">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (method_exists($workshops, 'links'))
                        <div class="mt-6">
                            {{ $workshops->links() }}
                        </div>
                    @endif
                @else
                    <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-sm text-slate-500">No workshops added yet.</div>
                @endif
            </section>

            <section class="panel p-6">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-700">Publishing Notes</p>
                <h3 class="mt-2 font-headline text-2xl font-extrabold text-slate-900">What makes the public card look better</h3>
                <div class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                    <p>Keep the title short and outcome-based so it feels premium on the public page.</p>
                    <p>Use only strong highlights. Three to five clear bullets work much better than long lists.</p>
                    <p>Make the subtitle practical and specific so learners know exactly what they will get.</p>
                </div>
            </section>
        </section>
    </div>
</main>
</body>
</html>
