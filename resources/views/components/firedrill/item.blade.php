@props(['firedrill', 'newRecord' => false])

<tr class="{{ $newRecord ? 'record-highlight' : '' }}">
    <td>{{ $firedrill->control_no }}</td>
    <td>{{ $firedrill->validity_term }}</td>
    <td>{{ $firedrill->receipt->or_no }}</td>
    <td>{{ date('F d, Y', strtotime($firedrill->date_made)) }}</td>
    <td>{{ $firedrill->issued_on ? date('m/d/Y', strtotime($firedrill->issued_on)) : '' }}</td>
    <td>
        @if ($firedrill->date_claimed)
            {{ date('m/d/Y', strtotime($firedrill->date_claimed)) }}
        @elseif ($firedrill->issued_on)
            <span class="text-danger">Unclaimed</span>
        @else
        @endif
    </td>
    <td>
        <button class="btn fw-bold btn-primary" onclick="openModal(`firedrill{{ $firedrill->id }}`)">
            Details
        </button>
    </td>
</tr>


<x-firedrill.detail :establishment="$firedrill->establishment" :firedrill="$firedrill" key="firedrill{{ $firedrill->id }}" />
