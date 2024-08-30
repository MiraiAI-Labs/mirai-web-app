@php
    $mode = $mode ?? null;
    
    if($mode != null){
        switch ($mode) {
            case 'light':
                $attributes['src'] = asset('images/logo.png');
                break;
            case 'dark':
                $attributes['src'] = asset('images/logo-dark.png');
                break;
            default:
                $attributes['src'] = asset('images/logo.png');
                break;
        }
    } else {
        $attributes['x-bind:src'] = "userTheme === 'light' ? '" . asset('images/logo.png') . "' : '" . asset('images/logo-dark.png') . "'";
    }
@endphp

<img {{ $attributes }} alt="" srcset="">