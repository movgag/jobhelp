<p>The status of job "{!! isset($job_title) ? $job_title : '' !!}" is changed to
    {!! isset($new_status) ? ($new_status ? 'active' : 'passive') : '' !!}!</p>