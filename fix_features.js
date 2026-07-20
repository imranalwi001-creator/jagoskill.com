const fs = require('fs');
const path = 'resources/views/admin/settings/general/features.blade.php';
let content = fs.readFileSync(path, 'utf8');

const keys = [
    'agora_live_streaming',
    'agora_chat',
    'agora_in_free_courses',
    'agora_for_meeting',
    'agora_for_events',
    'interactive_feature_toggle',
    'sequence_content_status',
    'webinar_assignment_status',
    'webinar_private_content_status',
    'disable_view_content_after_user_register',
    'cashback_active',
    'display_cashback_notice_in_the_product_page',
    'display_minimum_amount_cashback_notices',
];

let replacedCount = 0;

content = content.replace(/<label class=\"custom-switch pl-0\">\s*<input type=\"hidden\" name=\"value\[content_translate\]\" value=\"0\">\s*<span class=\"custom-switch-indicator\"><\/span>\s*<label class=\"custom-switch-description mb-0 cursor-pointer\" for=\"contentTranslate\">\{\{ trans\('([^']+)'\)\s*\}\}<\/label>\s*<\/label>\s*<div class=\"text-muted text-small mt-1\">Paid Plugin<\/div>/g, (match, transKey) => {
    let key = '';
    // map transKey to config key
    if (transKey === 'update.agora_live_streaming') key = 'agora_live_streaming';
    else if (transKey === 'update.agora_chat') key = 'agora_chat';
    else if (transKey === 'update.agora_in_free_courses') key = 'agora_in_free_courses';
    else if (transKey === 'update.agora_for_meeting') key = 'agora_for_meeting';
    else if (transKey === 'update.agora_for_events') key = 'agora_for_events';
    else if (transKey === 'update.interactive_feature_toggle') key = 'interactive_feature_toggle';
    else if (transKey === 'update.disable_view_content_after_user_register') key = 'disable_view_content_after_user_register';
    else if (transKey === 'update.cashback_active') key = 'cashback_active';
    else if (transKey === 'update.display_cashback_notice_in_the_product_page') key = 'display_cashback_notice_in_the_product_page';
    else if (transKey === 'update.display_minimum_amount_cashback_notices') key = 'display_minimum_amount_cashback_notices';
    else if (transKey === 'admin/main.active') {
        key = 'TODO_ACTIVE';
    } else {
        key = transKey.split('.').pop();
    }

    replacedCount++;
    return `<label class="custom-switch pl-0">
                            <input type="hidden" name="value[${key}]" value="0">
                            <input type="checkbox" name="value[${key}]" id="${key}Switch" value="1" {{ (!empty($itemValue) and !empty($itemValue['${key}']) and $itemValue['${key}']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                            <span class="custom-switch-indicator"></span>
                            <label class="custom-switch-description mb-0 cursor-pointer" for="${key}Switch">{{ trans('${transKey}') }}</label>
                        </label>`;
});

const activeKeys = ['sequence_content_status', 'webinar_assignment_status', 'webinar_private_content_status'];
let activeIndex = 0;
content = content.replace(/TODO_ACTIVE/g, () => {
    return activeKeys[activeIndex++];
});

// Also replace trans('update.attachment') which is missed if the regex was slightly off, wait, I can just use a similar regex for attachment.
content = content.replace(/<label class=\"custom-switch pl-0\">\s*<input type=\"hidden\" name=\"value\[content_translate\]\" value=\"0\">\s*<span class=\"custom-switch-indicator\"><\/span>\s*<label class=\"custom-switch-description mb-0 cursor-pointer\" for=\"contentTranslate\">\{\{\s*trans\('([^']+)'\)\s*\}\}<\/label>\s*<\/label>\s*<div class=\"text-muted text-small mt-1\">Paid Plugin<\/div>/g, (match, transKey) => {
    let key = 'attachment_TODO';
    replacedCount++;
    return `<label class="custom-switch pl-0">
                            <input type="hidden" name="value[${key}]" value="0">
                            <input type="checkbox" name="value[${key}]" id="${key}Switch" value="1" {{ (!empty($itemValue) and !empty($itemValue['${key}']) and $itemValue['${key}']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                            <span class="custom-switch-indicator"></span>
                            <label class="custom-switch-description mb-0 cursor-pointer" for="${key}Switch">{{ trans('${transKey}') }}</label>
                        </label>`;
});

fs.writeFileSync(path, content, 'utf8');
console.log('Replaced ' + replacedCount + ' fake toggles.');
