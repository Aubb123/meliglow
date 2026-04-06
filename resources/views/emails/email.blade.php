@extends('emails/app')

@section('content')

    <tr>
        <td bgcolor="#ffffff" style="padding: 30px 40px;">

            <p>
                {!! $emailMessage !!}
            </p>

        </td>
    </tr>

@endsection