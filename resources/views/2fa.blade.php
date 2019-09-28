<form method="post" action="{{route('twofa')}}">
    @csrf
    <input name="code">
    <button type="submit">Submit</button>
</form>
{{$msg}}
