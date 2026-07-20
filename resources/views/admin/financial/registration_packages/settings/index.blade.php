@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/financial/registration-packages">{{ trans('update.registration_packages') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">{{ trans('admin/main.general') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="instructors-tab" data-toggle="tab" href="#instructors" role="tab" aria-controls="instructors" aria-selected="false">{{ trans('admin/main.instructors') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="organizations-tab" data-toggle="tab" href="#organizations" role="tab" aria-controls="organizations" aria-selected="false">{{ trans('admin/main.organizations') }}</a>
                                </li>
                            </ul>
                            
                            <form action="{{ getAdminPanelUrl('/financial/registration-packages/settings') }}" method="post">
                                {{ csrf_field() }}

                                <div class="tab-content" id="myTabContent2">
                                    <!-- General Settings -->
                                    <div class="tab-pane mt-3 fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group custom-switches-stacked">
                                                    <label class="custom-switch pl-0">
                                                        <input type="hidden" name="value[status]" value="0">
                                                        <input type="checkbox" name="value[status]" id="statusSwitch" value="1" {{ (!empty($pageGeneralSettings) and !empty($pageGeneralSettings['status']) and $pageGeneralSettings['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 cursor-pointer" for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                                    </label>
                                                    <div class="text-muted text-small">{{ trans('update.registration_packages_general_status_hint') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Instructors Settings -->
                                    <div class="tab-pane mt-3 fade" id="instructors" role="tabpanel" aria-labelledby="instructors-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group custom-switches-stacked">
                                                    <label class="custom-switch pl-0">
                                                        <input type="hidden" name="value[instructors_status]" value="0">
                                                        <input type="checkbox" name="value[instructors_status]" id="instructorsStatusSwitch" value="1" {{ (!empty($instructorsSettings) and !empty($instructorsSettings['status']) and $instructorsSettings['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 cursor-pointer" for="instructorsStatusSwitch">{{ trans('admin/main.active') }}</label>
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.instructors_count') }}</label>
                                                    <input type="number" name="value[instructors_count]" class="form-control" value="{{ (!empty($instructorsSettings) and !empty($instructorsSettings['instructors_count'])) ? $instructorsSettings['instructors_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.students_count') }}</label>
                                                    <input type="number" name="value[instructors_students_count]" class="form-control" value="{{ (!empty($instructorsSettings) and !empty($instructorsSettings['students_count'])) ? $instructorsSettings['students_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.courses_capacity') }}</label>
                                                    <input type="number" name="value[instructors_courses_capacity]" class="form-control" value="{{ (!empty($instructorsSettings) and !empty($instructorsSettings['courses_capacity'])) ? $instructorsSettings['courses_capacity'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.courses_count') }}</label>
                                                    <input type="number" name="value[instructors_courses_count]" class="form-control" value="{{ (!empty($instructorsSettings) and !empty($instructorsSettings['courses_count'])) ? $instructorsSettings['courses_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.meeting_count') }}</label>
                                                    <input type="number" name="value[instructors_meeting_count]" class="form-control" value="{{ (!empty($instructorsSettings) and !empty($instructorsSettings['meeting_count'])) ? $instructorsSettings['meeting_count'] : '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Organizations Settings -->
                                    <div class="tab-pane mt-3 fade" id="organizations" role="tabpanel" aria-labelledby="organizations-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group custom-switches-stacked">
                                                    <label class="custom-switch pl-0">
                                                        <input type="hidden" name="value[organizations_status]" value="0">
                                                        <input type="checkbox" name="value[organizations_status]" id="organizationsStatusSwitch" value="1" {{ (!empty($organizationsSettings) and !empty($organizationsSettings['status']) and $organizationsSettings['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 cursor-pointer" for="organizationsStatusSwitch">{{ trans('admin/main.active') }}</label>
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.instructors_count') }}</label>
                                                    <input type="number" name="value[organizations_instructors_count]" class="form-control" value="{{ (!empty($organizationsSettings) and !empty($organizationsSettings['instructors_count'])) ? $organizationsSettings['instructors_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.students_count') }}</label>
                                                    <input type="number" name="value[organizations_students_count]" class="form-control" value="{{ (!empty($organizationsSettings) and !empty($organizationsSettings['students_count'])) ? $organizationsSettings['students_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.courses_capacity') }}</label>
                                                    <input type="number" name="value[organizations_courses_capacity]" class="form-control" value="{{ (!empty($organizationsSettings) and !empty($organizationsSettings['courses_capacity'])) ? $organizationsSettings['courses_capacity'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.courses_count') }}</label>
                                                    <input type="number" name="value[organizations_courses_count]" class="form-control" value="{{ (!empty($organizationsSettings) and !empty($organizationsSettings['courses_count'])) ? $organizationsSettings['courses_count'] : '' }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('update.meeting_count') }}</label>
                                                    <input type="number" name="value[organizations_meeting_count]" class="form-control" value="{{ (!empty($organizationsSettings) and !empty($organizationsSettings['meeting_count'])) ? $organizationsSettings['meeting_count'] : '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
