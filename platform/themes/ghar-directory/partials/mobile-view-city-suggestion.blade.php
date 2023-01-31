
<div class="allCitiesBoxx">
    <ul>
        @foreach($items as $key => $city)
                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                    <a href="{{ route('public.properties-by-city', $city->slug) }}" class="Top_Misc_L3 redirect_to" cityid="{{ $city->id}}" cityname="{{ $city->name}}" slugcityname="{{ $city->slug}}" redirect_to="">{{ $city->name}}</a>
                </li>
        @endforeach
    </ul>
</div>
