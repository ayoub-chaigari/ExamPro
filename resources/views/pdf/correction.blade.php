@extends('pdf.layout')

@section('title', 'Corrigé - ' . $exam->title)

@section('exam_title', 'CORRIGÉ DE L\'ÉVALUATION')

@section('filiere', $exam->category->name)
@section('module_name', $exam->title)
@section('duree', $exam->duration)
@section('bareme', '/' . $exam->total_points)

@section('content')
    <div style="text-align: center; margin-top: 20px; margin-bottom: 30px;">
        <h2 style="color: #1e3a8a; text-transform: uppercase; display: inline-block; border-bottom: 3px solid #1e3a8a; padding-bottom: 5px;">
            Guide de Correction
        </h2>
    </div>

    @php $globalIndex = 1; @endphp

    @foreach($exam->sections as $section)
        @php
            $correctionQuestions = $section->questions->filter(function($q) {
                return in_array(strtolower($q->type), ['qcm', 'true_false', 'mcq', 'tf']);
            })->sortBy('order');
        @endphp

        @if($correctionQuestions->count() > 0)
            <div style="margin-bottom: 30px; page-break-inside: avoid;">
                <div style="background-color: #f8fafc; padding: 10px 15px; border-left: 6px solid #1e3a8a; margin-bottom: 15px;">
                    <h3 style="margin: 0; font-size: 16px; color: #1e3a8a; text-transform: uppercase;">
                        {{ $section->title }}
                    </h3>
                </div>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #1e3a8a; color: white; font-size: 12px; text-transform: uppercase;">
                            <th style="padding: 12px; border: 1px solid #1e3a8a; text-align: center; width: 10%;">N°</th>
                            <th style="padding: 12px; border: 1px solid #1e3a8a; text-align: left; width: 60%;">Question / Enoncé</th>
                            <th style="padding: 12px; border: 1px solid #1e3a8a; text-align: center; width: 30%;">Réponse Correcte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($correctionQuestions as $question)
                            <tr style="background-color: {{ $loop->even ? '#fdfdfd' : '#ffffff' }};">
                                <td style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-weight: bold; color: #64748b;">
                                    {{ $globalIndex++ }}
                                </td>
                                <td style="padding: 12px; border: 1px solid #e2e8f0; font-size: 13px;">
                                    {!! Str::limit(strip_tags($question->content), 100) !!}
                                </td>
                                <td style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-weight: 900; color: #1e3a8a; font-size: 14px;">
                                    @if(in_array(strtolower($question->type), ['qcm', 'mcq']))
                                        {{ strtoupper($question->correct_answer) }}
                                    @elseif(in_array(strtolower($question->type), ['true_false', 'tf']))
                                        @if(in_array(strtolower($question->correct_answer), ['true', '1', 'vrai', 'v']))
                                            <span style="color: #059669;">VRAI</span>
                                        @else
                                            <span style="color: #dc2626;">FAUX</span>
                                        @endif
                                    @else
                                        {{ $question->correct_answer }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach

    <div style="margin-top: 50px; border: 1px dashed #cbd5e1; padding: 15px; background-color: #f8fafc; font-size: 11px; color: #64748b; font-style: italic; text-align: center;">
        Ce document est généré automatiquement par le système de gestion des examens. 
        Veuillez vérifier les réponses en cas de doute.
    </div>
@endsection
