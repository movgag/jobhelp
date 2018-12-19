<p>Dear {{ isset($data['employee_full_name']) ? $data['employee_full_name'] : 'User' }}, </p>
<p>{{ isset($data['company_name']) ? $data['company_name'] : 'company' }}
    is {{ isset($data['company_decision']) ? $data['company_decision'] : '?????' }}
    Your application for job "{{ isset($data['job_title']) ? $data['job_title'] : 'undefined' }}" .</p>
<p>Message:</p>
<p>{{ isset($data['company_decision_text']) ? $data['company_decision_text'] : '' }}</p>