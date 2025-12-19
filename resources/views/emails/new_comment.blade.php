<h1>New Comment on: {{ $postTitle }}</h1>
<p><strong>{{ $commentAuthor }}</strong> said:</p>
<blockquote>{{ $commentBody }}</blockquote>
<a href="{{ url('/blog/' . $post->slug) }}">View Post</a>