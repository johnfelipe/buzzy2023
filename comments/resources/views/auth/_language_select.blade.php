@php($languages = get_available_languages())
@php($userLanguage = get_current_user_language())
<select name="userLanguage" id="userLanguage" class="form-control change_user_language">
    @foreach($languages as $language)
        <option value="{{$language}}" @if($userLanguage === $language) selected @endif>{{$language}} ({{get_translatable_language($language)}})</option>
    @endforeach
</select>
