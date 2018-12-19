<p>Name: {{ isset($data['name']) ? $data['name'] : '' }}</p>
<p>Email: {{ isset($data['sender_email']) ? $data['sender_email'] : '' }}</p>
<p>Message: {{ isset($data['message']) ? $data['message'] : '' }}</p>