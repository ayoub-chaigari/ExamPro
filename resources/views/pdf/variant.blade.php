@extends('pdf.layout')

@section('title', 'Examen - Variante ' . $variant->name)

@section('exam_title', $exam->type === 'efm' ? 'EVALUATION DE FIN DE MODULE LOCAL' : 'EXAMEN')

@section('filiere', $exam->category->name ?? 'N/A')
@section('niveau', $exam->niveau ?? '______________________')
@section('module_no', $exam->module_no ?? '_____')
@section('module_name', $exam->title)
@section('variante', $variant->name)
@section('duree', $exam->duration)
@section('bareme', $exam->bareme ?? '/20')
@section('date', date('d/m/Y', strtotime($exam->created_at)))

@section('content')
    <style>
        .section-title { font-size: 16px; font-weight: bold; color: #1e3a8a; border-bottom: 2px solid #f97316; padding-bottom: 3px; display: inline-block; margin-top: 25px; margin-bottom: 10px; }
        .section-desc { font-style: italic; color: #4b5563; margin-bottom: 15px; font-size: 13px; }
        
        .question { margin-bottom: 16px; page-break-inside: avoid; }
        .question-table { width: 100%; border-collapse: collapse; }
        .question-num { font-weight: bold; color: #1e3a8a; white-space: nowrap; vertical-align: top; padding-right: 4px; width: 30px; font-size: 14px; }
        .question-body { vertical-align: top; color: #1e3a8a; font-weight: bold; font-size: 14px; }
        .question-body p { margin: 0; padding: 0; }
        .question-content table { border-collapse: collapse; width: 100%; margin: 10px 0; page-break-inside: avoid; }
        .question-content table, .question-content th, .question-content td { border: 1px solid #374151; padding: 8px; }
        .question-content th { background-color: #f3f4f6; }
        .question-content img { max-width: 100%; height: auto; margin: 10px 0; }
        
        .options { list-style-type: lower-alpha; margin-top: 5px; padding-left: 20px; }
        .options li { margin-bottom: 5px; }
        .tf-options { margin-top: 10px; margin-bottom: 15px; }
        .tf-box { display: inline-block; width: 15px; height: 15px; border: 1px solid #1e3a8a; margin-right: 8px; vertical-align: middle; }
        
        .answer-space { border: 1px dotted #9ca3af; width: 100%; margin-top: 10px; }
        .space-small { height: 50px; }
        .space-medium { height: 120px; }
        .space-large { height: 250px; }
        
        .points { float: right; font-weight: bold; font-size: 12px; color: #f97316; }
        
        .student-info-input { margin-bottom: 30px; font-weight: bold; font-size: 14px; margin-top: 20px; color: #f97316; border-bottom: 1px solid #f97316; padding-bottom: 5px; }
    </style>

    <div class="student-info-input">
        Nom et Prénom du stagiaire : _____________________________________________
    </div>

    <!-- Sections and Questions -->
    <div class="questions">
        @foreach($exam->sections as $section)
            <div class="section-title">{{ $section->title }}</div>
            @if($section->description)
                <div class="section-desc">{{ $section->description }}</div>
            @endif
            
            @php
                $topQuestions = $questions->where('section_id', $section->id)->whereNull('parent_id')->sortBy('pivot.order');
                $qNum = 1;
            @endphp
            
            @forelse($topQuestions as $question)
                <div class="question">
                    @if($question->type === 'consigne')
                        <div class="question-content" style="font-style: italic; font-weight: bold; background: #fff7ed; padding: 12px; border-left: 4px solid #f97316; color: #9a3412;">
                            {!! $question->pivot->custom_text ?? $question->content !!}
                        </div>
                    @else
                        <table class="question-table">
                            <tr>
                                <td class="question-num">{{ $qNum }}-</td>
                                <td class="question-body">
                                    {!! $question->pivot->custom_text ?? $question->content !!}
                                    <span class="points">({{ $question->points }} pts)</span>
                                </td>
                            </tr>
                        </table>
                        
                        @if($question->type == 'mcq')
                            @php
                                $options = $question->pivot->shuffled_options ? json_decode($question->pivot->shuffled_options) : ($question->options ?? []);
                            @endphp
                            <ul class="options">
                                @foreach($options as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @elseif($question->type == 'tf')
                            <div class="tf-options">
                                <span class="tf-box"></span> Vrai 
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="tf-box"></span> Faux
                            </div>
                        @else
                            @if($question->requires_answer_space)
                                <div class="answer-space space-{{ $question->answer_space_size ?? 'small' }}" style="border-color: #f97316;"></div>
                            @endif
                        @endif

                        <!-- Render Sub-Questions -->
                        @php
                            $subQs = $questions->where('parent_id', $question->id)->sortBy('pivot.order');
                            $subLetters = range('a', 'z');
                        @endphp
                        @if($subQs->count() > 0)
                            <div style="margin-top: 15px; margin-left: 20px; border-left: 1px dashed #e5e7eb; padding-left: 10px;">
                                @foreach($subQs as $subIndex => $subQ)
                                    <div class="question" style="margin-bottom: 12px;">
                                        @if($subQ->type === 'consigne')
                                            <div class="question-content" style="font-style: italic; font-weight: bold; background: #fff7ed; padding: 8px 12px; border-left: 3px solid #f97316; color: #9a3412; font-size: 12px;">
                                                {!! $subQ->pivot->custom_text ?? $subQ->content !!}
                                            </div>
                                        @else
                                            <table class="question-table">
                                                <tr>
                                                    <td class="question-num" style="font-size: 13px;">{{ $qNum }}.{{ $subLetters[$subIndex] ?? $subIndex }})</td>
                                                    <td class="question-body" style="font-size: 13px;">
                                                        {!! $subQ->pivot->custom_text ?? $subQ->content !!}
                                                        <span class="points">({{ $subQ->points }} pts)</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        @if($subQ->type == 'mcq')
                                            @php
                                                $subOptions = $subQ->pivot->shuffled_options ? json_decode($subQ->pivot->shuffled_options) : ($subQ->options ?? []);
                                            @endphp
                                            <ul class="options" style="font-size: 13px;">
                                                @foreach($subOptions as $opt)
                                                    <li>{{ $opt }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif($subQ->type == 'tf')
                                            <div class="tf-options" style="font-size: 13px;">
                                                <span class="tf-box"></span> Vrai 
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="tf-box"></span> Faux
                                            </div>
                                        @else
                                            @if($subQ->requires_answer_space)
                                                <div class="answer-space space-{{ $subQ->answer_space_size ?? 'small' }}"></div>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        @php $qNum++; @endphp
                    @endif
                </div>
            @empty
                <div style="font-style: italic; color: #9ca3af; text-align: center; padding: 10px;">Aucune question pour cette section.</div>
            @endforelse
        @endforeach
    </div>
@endsection
