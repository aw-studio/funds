<h2>FAQ</h2>

@foreach ($faqs as $faq)
    <h3>{{ $faq->question }}</h3>
    <p>{{ $faq->answer }}</p>
@endforeach
