<div class="modal fade" id="restrictionModal" tabindex="-1" role="dialog" aria-labelledby="restrictionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restrictionModalLabel">
                    {{ !empty($restriction) ? trans('admin/main.edit') : trans('update.add_new_restriction') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="restrictionForm" action="{{ !empty($restriction) ? getAdminPanelUrl("/users/ip-restriction/{$restriction->id}/update") : getAdminPanelUrl("/users/ip-restriction/store") }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="input-label">{{ trans('admin/main.type') }}</label>
                        <select name="type" class="form-control">
                            <option value="">{{ trans('admin/main.select_type') }}</option>
                            <option value="full_ip" {{ (!empty($restriction) && $restriction->type == 'full_ip') ? 'selected' : '' }}>{{ trans('update.full_ip') }}</option>
                            <option value="ip_range" {{ (!empty($restriction) && $restriction->type == 'ip_range') ? 'selected' : '' }}>{{ trans('update.ip_range') }}</option>
                            <option value="country" {{ (!empty($restriction) && $restriction->type == 'country') ? 'selected' : '' }}>{{ trans('admin/main.country') }}</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Full IP Field -->
                    <div class="form-group js-restriction-field js-field-full_ip {{ (!empty($restriction) && $restriction->type == 'full_ip') ? '' : ((empty($restriction) && !empty($defaultFullIP)) ? '' : 'd-none') }}">
                        <label class="input-label">{{ trans('update.full_ip') }}</label>
                        <input type="text" name="full_ip" value="{{ !empty($restriction) ? $restriction->value : ($defaultFullIP ?? '') }}" class="form-control" placeholder="e.g. 192.168.1.1">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- IP Range Field -->
                    <div class="form-group js-restriction-field js-field-ip_range {{ (!empty($restriction) && $restriction->type == 'ip_range') ? '' : 'd-none' }}">
                        <label class="input-label">{{ trans('update.ip_range') }} (CIDR)</label>
                        <input type="text" name="ip_range" value="{{ !empty($restriction) ? $restriction->value : '' }}" class="form-control" placeholder="e.g. 192.168.1.0/24">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Country Field -->
                    <div class="form-group js-restriction-field js-field-country {{ (!empty($restriction) && $restriction->type == 'country') ? '' : 'd-none' }}">
                        <label class="input-label">{{ trans('admin/main.country') }}</label>
                        <input type="text" name="country" value="{{ !empty($restriction) ? $restriction->value : '' }}" class="form-control" placeholder="e.g. US or ID">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Reason -->
                    <div class="form-group">
                        <label class="input-label">{{ trans('update.reason') }}</label>
                        <textarea name="reason" rows="4" class="form-control">{{ !empty($restriction) ? $restriction->reason : '' }}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveRestrictionBtn">{{ trans('admin/main.save') }}</button>
            </div>
        </div>
    </div>
</div>
