@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <form action="/admin/translator/translate" method="post" id="translatorForm">
                                        {{ csrf_field() }}
                                        
                                        <div class="form-group">
                                            <label>Target Language</label>
                                            <select name="language" class="form-control select2" required>
                                                <option value="" disabled selected>Select Language</option>
                                                @foreach(getLanguages() as $key => $language)
                                                    <option value="{{ mb_strtolower($key) }}">{{ $language }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-muted text-small mt-1">Select the language you want to translate the English files into.</div>
                                        </div>

                                        <div class="form-group">
                                            <label>Translation Mode</label>
                                            <select name="mode" class="form-control" id="translationMode">
                                                <option value="all">Translate All Files</option>
                                                <option value="specific">Translate Specific File</option>
                                            </select>
                                        </div>

                                        <div class="form-group d-none" id="specificFilesInput">
                                            <label>Select Specific File</label>
                                            @php
                                                function flattenLangFiles($array, $prefix = '') {
                                                    $result = [];
                                                    foreach ($array as $key => $value) {
                                                        if (is_array($value)) {
                                                            $result = array_merge($result, flattenLangFiles($value, $prefix . $key . '/'));
                                                        } else {
                                                            $result[] = $prefix . $value;
                                                        }
                                                    }
                                                    return $result;
                                                }
                                                $flatFiles = flattenLangFiles($langFiles ?? []);
                                            @endphp
                                            <select name="lang_files[]" class="form-control select2" multiple>
                                                @foreach($flatFiles as $file)
                                                    <option value="{{ $file }}">{{ $file }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="specific_file" value="1" disabled id="specificFileHidden">
                                        </div>

                                        <button type="submit" class="btn btn-primary" id="translateSubmitBtn">
                                            <i class="fa fa-language"></i> Start Translation (Unlocked)
                                        </button>
                                        <div class="mt-2 text-warning d-none" id="translateLoadingMsg">
                                            <i class="fas fa-spinner fa-spin"></i> Translating... Please wait (this can take up to 10-20 minutes for all files). Do not close this window.
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
<script>
    (function($){
        "use strict";
        
        $('#translationMode').on('change', function() {
            if($(this).val() === 'specific') {
                $('#specificFilesInput').removeClass('d-none');
                $('#specificFileHidden').removeAttr('disabled');
            } else {
                $('#specificFilesInput').addClass('d-none');
                $('#specificFileHidden').attr('disabled', 'disabled');
            }
        });

        $('#translatorForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $('#translateSubmitBtn');
            var $msg = $('#translateLoadingMsg');
            
            $btn.addClass('btn-loading disabled').prop('disabled', true);
            $msg.removeClass('d-none');
            
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $btn.removeClass('btn-loading disabled').prop('disabled', false);
                    $msg.addClass('d-none');
                    if(res.code === 200) {
                        alert("Success! " + res.msg);
                    } else {
                        alert("Warning: " + (res.error || "Completed with some errors."));
                    }
                },
                error: function(err) {
                    $btn.removeClass('btn-loading disabled').prop('disabled', false);
                    $msg.addClass('d-none');
                    alert("Error processing translation. Check server logs.");
                }
            });
        });
    })(jQuery);
</script>

@endpush
