@if(!empty($forPdf))
<p style="text-align:center;margin:0 0 16px 0;"><img src="{{ public_path('logo.svg') }}" alt="logo" style="height:60px;" /></p>
@endif

<p align="center">{{ $lookingForCandidates }}</p>
<p align="center"><strong>{{ $nameOfThePosition }}</strong></p>
<p align="center">{{ $location }}</p>
<p align="center"><strong>{{ $jobDescription }}</strong></p>
<p></p>
<p align="center"><strong>{{ $keyResponsibilities }}</strong></p>
@if(!empty($option1))
<p>{{ $option1 }}</p>
@endif
@if(!empty($respItems ?? []))
<ul>
@foreach(($respItems ?? []) as $item)
<li>{{ $item }}</li>
@endforeach
</ul>
@endif
@if(!empty($option2Title))
<p><strong>{{ $option2Title }}</strong></p>
@endif
@if(!empty($option2))
<ul>
<li>{{ $option2 }}</li>
</ul>
@endif
<p></p>
<p align="center"><strong>{{ $ourRequirements }}</strong></p>
@if(!empty($reqItems ?? []))
<ul>
@foreach(($reqItems ?? []) as $item)
<li>{{ $item }}</li>
@endforeach
</ul>
@endif
<p></p>
<p align="center"><strong>{{ $weOffer }}</strong></p>
@if(!empty($offerItems ?? []))
<ul>
@foreach(($offerItems ?? []) as $item)
<li>{{ $item }}</li>
@endforeach
</ul>
@endif

<p>{!! $clauses !!}</p>
@if(empty($forPdf))
<p><a title="Job description in pdf file" href="/storage/job_descriptions/{{ $file_name }}.pdf" target="_blank" rel="alternate">
<img style="display: block; margin-left: auto; margin-right: auto;" src={{ asset('pdf48x48.png') }} alt="pdf" /></a></p>
@endif