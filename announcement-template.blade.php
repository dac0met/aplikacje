<p align="center">{{ $lookingForCandidates /* "We are looking for candidates on the position of" */ }}</p>
<p align="center"><strong>{{ $nameOfThePosition }}</strong></p>
<p align="center">{{ $location /*Location: Bydgoszcz */ }}</p>
<p align="center"><strong>{{ $jobDescription }}</strong></p>
<p></p>
<p align="center"><strong>{{ $keyResponsibilities }}</strong></p>
<p>{{ $option1}}</p>
<ul>
{{-- ilość pozycji listy jest zmienna --}}    
<li></li>
<li></li>
<li></li>
<li></li>
<p>{{ $option2}}</p>
</ul>


<p align="center"><strong>{{ $ourRequirements }}</strong></p>
<ul>
{{-- ilość pozycji listy jest zmienna --}} 
<li></li>
<li></li>
<li></li>
<li></li>
<p>{{ $option3}}</p>
</ul>

<p align="center"><strong>{{ $weOffer }}</strong></p>
<ul>
{{-- ilość pozycji listy jest zmienna --}} 
<li></li>
<li></li>
<li></li>
<li></li>
</ul>

<p>{{ $clauses }}</p>
<p><a title="Job description in pdf file" href="/storageapp/public/job_descriptions/{{ $file_name }}.pdf" target="_blank" rel="alternate">
<img style="display: block; margin-left: auto; margin-right: auto;" src="/public/pdf48x48.png" alt="pdf" /></a></p>