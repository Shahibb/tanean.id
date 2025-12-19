{{-- resources/views/articles/show.blade.php --}}
@extends('layouts.app')

@section('title', $article->title . ' - TANEAN.ID')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Debug Info --}}
    @if(config('app.debug'))
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="font-semibold">Debug Mode</span>
        </div>
        <div class="text-sm space-y-1">
            <p>Article ID: {{ $article->id }}</p>
            <p>Has AI Summary: {{ $article->ai_summary ? 'Yes' : 'No' }}</p>
            <p>AI Summary Content: {{ Str::limit($article->ai_summary ?? 'null', 50) }}</p>
            <p>Summary Generated At: {{ $article->summary_generated_at ?? 'null' }}</p>
            <p>Is Published: {{ $article->is_published ? 'Yes' : 'No' }}</p>
            <p>CSRF Token: {{ csrf_token() ? 'Exists' : 'Missing' }}</p>
        </div>
    </div>
    @endif

    <article class="bg-white rounded-lg shadow-sm p-6 md:p-8">
        {{-- Meta Info --}}
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <span class="px-3 py-1 bg-tanean-green text-white text-sm font-semibold rounded-full">
                {{ $article->category }}
            </span>
            @if ($article->is_published)
                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                    Terbit
                </span>
            @else
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                    Draft
                </span>
            @endif

            @if($article->ai_summary)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    Ringkasan AI Tersedia
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="text-3xl md:text-4xl font-bold text-tanean-dark mb-4 leading-tight">
            {{ $article->title }}
        </h1>

        {{-- Image --}}
        @if ($article->image)
            <div class="mb-8 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $article->image) }}"
                     alt="{{ $article->title }}"
                     class="w-full h-auto object-cover"
                     loading="lazy">
            </div>
        @endif

        {{-- Author & Date --}}
        <div class="flex items-center gap-4 text-gray-600 mb-8">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>By <strong>{{ $article->author }}</strong></span>
            </div>
            <span class="hidden md:inline">•</span>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span>{{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}</span>
            </div>
        </div>

        {{-- AI Summary Section --}}
        <div id="ai-summary-section" class="mb-8 p-6 bg-gradient-to-r from-tanean-beige to-gray-50 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-tanean-dark">
                        @if($article->ai_summary)
                            Ringkasan AI
                        @else
                            Buat Ringkasan AI
                        @endif
                    </h3>
                    @if($article->ai_summary && $article->summary_generated_at)
                        <p class="text-sm text-gray-500 mt-1">
                            Dibuat {{ $article->summary_generated_at->diffForHumans() }}
                            @if($article->summary_model_used)
                                • Model: {{ $article->summary_model_used }}
                            @endif
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2">
                    {{-- Tampilkan tombol yang sesuai --}}
                    @if($article->ai_summary)
                        {{-- Jika sudah ada summary, tampilkan Refresh --}}
                        <button id="refresh-summary"
                            class="px-5 py-2.5 bg-tanean-green hover:bg-tanean-green-dark text-white font-medium rounded-lg transition duration-200 flex items-center gap-2 shadow-sm cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Refresh Ringkasan</span>
                        </button>

                        <button id="generate-new-summary"
                            class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200 flex items-center gap-2 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>Buat Baru</span>
                        </button>
                    @else
                        {{-- Jika belum ada summary, tampilkan Buat Ringkasan --}}
                        <button id="generate-summary"
                            class="px-5 py-2.5 bg-tanean-green hover:bg-tanean-green-dark text-white font-medium rounded-lg transition duration-200 flex items-center gap-2 shadow-sm cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Buat Ringkasan AI</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Summary Display --}}
            @if($article->ai_summary)
            <div id="summary-content" class="mb-4">
                <div class="prose max-w-none bg-white p-4 rounded-lg border border-gray-100">
                    <p id="summary-text" class="text-gray-700 leading-relaxed">
                        {{ $article->ai_summary }}
                    </p>
                </div>

                <div class="mt-3 flex justify-between items-center text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span>Dibuat oleh AI • Mungkin ada ketidakakuratan</span>
                    </div>
                    <button id="copy-summary"
                            class="text-tanean-green hover:text-tanean-green-dark flex items-center gap-1 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin
                    </button>
                </div>
            </div>
            @endif

            {{-- Loading State --}}
            <div id="summary-loading" class="hidden py-8">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-12 h-12 border-4 border-tanean-green border-t-transparent rounded-full animate-spin mb-4"></div>
                    <p class="text-gray-600 font-medium">Membuat ringkasan dengan AI...</p>
                    <p class="text-gray-500 text-sm mt-1">Mohon tunggu sebentar</p>
                </div>
            </div>

            {{-- Error State --}}
            <div id="summary-error" class="hidden py-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Gagal membuat ringkasan</h4>
                    <p id="error-message" class="text-gray-600 mb-4">
                        Terjadi kesalahan saat membuat ringkasan. Silakan coba lagi.
                    </p>
                    <button id="retry-summary"
                            class="px-4 py-2 bg-tanean-green hover:bg-tanean-green-dark text-white rounded-lg transition duration-200 cursor-pointer">
                        Coba Lagi
                    </button>
                </div>
            </div>

            {{-- Empty State -- hanya tampil jika tidak ada summary --}}
            @if(!$article->ai_summary)
            <div id="summary-empty" class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500">Belum ada ringkasan yang dibuat</p>
                <p class="text-sm text-gray-400 mt-1">Klik tombol di atas untuk membuat ringkasan dengan AI</p>
            </div>
            @endif
        </div>

        {{-- Article Content --}}
        <div class="prose max-w-none mb-8">
            <p class="text-lg text-gray-700 mb-6 italic border-l-4 border-tanean-green pl-4 py-2 bg-gray-50">
                {{ $article->excerpt }}
            </p>

            <div class="article-content text-gray-800 leading-relaxed">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </article>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== AI Summary Script Loaded ===');

    // Setup event listeners berdasarkan kondisi
    setupEventListeners();

    function setupEventListeners() {
        const articleId = {{ $article->id }};

        // Tombol Generate (hanya ada jika belum ada summary)
        const generateBtn = document.getElementById('generate-summary');
        if (generateBtn) {
            console.log('✅ Setup listener for generate button');
            generateBtn.addEventListener('click', function(e) {
                console.log('🎯 Generate button clicked');
                e.preventDefault();
                generateAISummary(articleId, false);
            });
        }

        // Tombol Refresh (hanya ada jika sudah ada summary)
        const refreshBtn = document.getElementById('refresh-summary');
        if (refreshBtn) {
            console.log('✅ Setup listener for refresh button');
            refreshBtn.addEventListener('click', function(e) {
                console.log('🔄 Refresh button clicked');
                e.preventDefault();
                generateAISummary(articleId, true);
            });
        }

        // Tombol Generate New (alternative refresh)
        const generateNewBtn = document.getElementById('generate-new-summary');
        if (generateNewBtn) {
            console.log('✅ Setup listener for generate-new button');
            generateNewBtn.addEventListener('click', function(e) {
                console.log('🆕 Generate new button clicked');
                e.preventDefault();
                generateAISummary(articleId, true);
            });
        }

        // Tombol Copy
        const copyBtn = document.getElementById('copy-summary');
        if (copyBtn) {
            console.log('✅ Setup listener for copy button');
            copyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                copySummaryToClipboard();
            });
        }

        // Tombol Retry
        const retryBtn = document.getElementById('retry-summary');
        if (retryBtn) {
            console.log('✅ Setup listener for retry button');
            retryBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const articleId = {{ $article->id }};
                generateAISummary(articleId, false);
            });
        }
    }

    async function generateAISummary(articleId, forceRefresh = false) {
        console.log(`🚀 generateAISummary called: articleId=${articleId}, forceRefresh=${forceRefresh}`);

        // Show loading state
        setUIState('loading');

        try {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken.substring(0, 10) + '...');

            // Prepare request
            const url = `/api/article/${articleId}/summarize`;
            console.log('Request URL:', url);

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('force_refresh', forceRefresh ? '1' : '0');

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            // Parse response
            const data = await response.json();
            console.log('Response data:', data);

            if (response.ok && data.success) {
                // Success - update UI
                updateSummaryUI(data.data.summary);
                showNotification('✅ Ringkasan berhasil dibuat!', 'success');

                // If this was a first-time generate, reload page to show new buttons
                if (!document.getElementById('refresh-summary')) {
                    console.log('First time generate, reloading page...');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } else {
                throw new Error(data.message || 'Gagal membuat ringkasan');
            }

        } catch (error) {
            console.error('❌ Error in generateAISummary:', error);

            // Show error
            const errorMsg = document.getElementById('error-message');
            if (errorMsg) {
                errorMsg.textContent = error.message || 'Terjadi kesalahan tidak diketahui';
            }
            setUIState('error');
            showNotification(`❌ ${error.message || 'Gagal membuat ringkasan'}`, 'error');
        }
    }

    function updateSummaryUI(summaryText) {
        console.log('Updating UI with new summary');

        // Hide loading
        setUIState('success');

        // Update summary text
        const summaryTextEl = document.getElementById('summary-text');
        if (summaryTextEl) {
            summaryTextEl.textContent = summaryText;
        } else {
            // Create summary display if it doesn't exist
            const summaryEmpty = document.getElementById('summary-empty');
            if (summaryEmpty) {
                summaryEmpty.innerHTML = `
                    <div class="prose max-w-none bg-white p-4 rounded-lg border border-gray-100 mb-4">
                        <p id="summary-text" class="text-gray-700 leading-relaxed">
                            ${summaryText}
                        </p>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span>Dibuat oleh AI • Mungkin ada ketidakakuratan</span>
                        </div>
                        <button id="copy-summary-new" class="text-tanean-green hover:text-tanean-green-dark flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Salin
                        </button>
                    </div>
                `;

                // Add event listener to new copy button
                const newCopyBtn = document.getElementById('copy-summary-new');
                if (newCopyBtn) {
                    newCopyBtn.addEventListener('click', copySummaryToClipboard);
                }
            }
        }
    }

    function setUIState(state) {
        console.log('Setting UI state:', state);

        const elements = {
            loading: document.getElementById('summary-loading'),
            error: document.getElementById('summary-error'),
            content: document.getElementById('summary-content'),
            empty: document.getElementById('summary-empty')
        };

        // Hide all first
        Object.values(elements).forEach(el => {
            if (el) el.classList.add('hidden');
        });

        // Show based on state
        switch(state) {
            case 'loading':
                if (elements.loading) elements.loading.classList.remove('hidden');
                if (elements.content) elements.content.classList.add('hidden');
                break;

            case 'error':
                if (elements.error) elements.error.classList.remove('hidden');
                if (elements.content) elements.content.classList.add('hidden');
                break;

            case 'success':
                if (elements.content) elements.content.classList.remove('hidden');
                if (elements.empty) elements.empty.classList.add('hidden');
                break;
        }
    }

    function copySummaryToClipboard() {
        const summaryText = document.getElementById('summary-text');
        if (!summaryText) {
            console.error('No summary text to copy');
            return;
        }

        const text = summaryText.textContent;
        navigator.clipboard.writeText(text).then(() => {
            // Show feedback
            const copyBtn = document.getElementById('copy-summary') ||
                           document.getElementById('copy-summary-new');
            if (copyBtn) {
                const originalHTML = copyBtn.innerHTML;
                copyBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tersalin!
                `;
                copyBtn.classList.remove('text-tanean-green');
                copyBtn.classList.add('text-green-600');

                setTimeout(() => {
                    copyBtn.innerHTML = originalHTML;
                    copyBtn.classList.remove('text-green-600');
                    copyBtn.classList.add('text-tanean-green');
                }, 2000);
            }

            showNotification('✓ Ringkasan disalin ke clipboard', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            showNotification('❌ Gagal menyalin teks', 'error');
        });
    }

    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(el => el.remove());

        // Create notification
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg transform transition-transform duration-300 z-50 ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                ${type === 'success' ?
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>' :
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>'
                }
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateY(-100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Ekspos fungsi ke window untuk testing
    window.testGenerateSummary = () => generateAISummary({{ $article->id }}, false);
    window.testRefreshSummary = () => generateAISummary({{ $article->id }}, true);
});
</script>
@endpush

<style>
.article-content {
    line-height: 1.8;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1f2937;
}

.article-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #374151;
}

.article-content ul, .article-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content blockquote {
    border-left: 4px solid #10b981;
    padding-left: 1rem;
    font-style: italic;
    color: #4b5563;
    margin: 1.5rem 0;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection