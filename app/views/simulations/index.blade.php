@extends('master')

@section('page-js')
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="/scripts/lib/autobahn.js"></script>
<script src="/scripts/simulations/dashboard.js"></script>
<script>
  function duplicateLink(id) { return "{{ URL::route('simulation.duplicate', ['ID']) }}".replace('ID', id); };
  function rebuildLink(id) { return "{{ URL::route('simulation.rebuild', ['ID']) }}".replace('ID', id); };
  function segmentedLesionLink(id) { return "{{ URL::route('simulation.getSegmentedLesion', ['ID']) }}".replace('ID', id); };
  function xmlLink(id) { return "{{ URL::route('simulation.show', ['ID']) }}".replace('ID', id); };
  function htmlLink(id) { return "{{ URL::route('simulation.show', ['ID', 'html' => '1']) }}".replace('ID', id); };
  function jsonLink(id) { return "{{ URL::route('simulation.table', ['ID']) }}".replace('ID', id); };
  function editLink(id) { return "{{ URL::route('simulation.edit', ['ID']) }}".replace('ID', id); };
  var preferred_server = "{{{ $preferred_server }}}";
</script>
@stop

@section('content')

<h1>Simulations</h1>
<p>{{ link_to_route('home', '&rarr; to index') }}</p>
<p>{{ link_to_route('simulation.backup', 'Backup all with prefix NUMA', ['prefix' => 'NUMA']) }} | <a href='#' id='diffLink' class='disabled'>Diff two simulations</a> | <a href='javascript:toggleUnsimulated()'>Toggle unsimulated</a></p>

<script>
var simulations = {
@foreach ($simulations as $simulation)
  '{{ $simulation->Id }}': {{ $simulation->toJson(); }},
@endforeach
  '': ''
}

function updateParameters()
{
  parameter_name = $('#parameter-request').val();

  $('.simulations').each(function (i, simulationRow) {
    var simulation = simulations[simulationRow.id];
    var combination_id = simulation.Combination_Id;
    $.getJSON('/combination/' + simulation.Combination_Id + '/parameter/' + parameter_name, {}, function(data) {
      $('#simulation-' + simulation.Id + '-parameter').html(data);
    });
  });

}
</script>
<input id='parameter-request'/>
<input type='button' value='Show Parameters' onClick='updateParameters()' />

<h2>Servers Connected</h2>

<table>
<thead>
  <tr><td></td><td>Server to use</td><td>Hostname</td><td>Score</td></tr>
</thead>
<tbody id='servers-table'>
</tbody>
</table>

<p><a name='updatePreferredServer' href="{{ URL::route('simulation.updatePreferredServer') }}">Update preferred server</a></p>

<h2>Modalities</h2>

<p>
{{ implode(' | ', $modalities->map(function ($m) { return HTML::linkRoute('simulation.index', $m->Name, ['modality' => $m->Id]); })->toArray()); }}
</p>

<h2>Simulations</h2>

<div id='patientList'></div>
<table class='simulations-table'>
</table>

<h1>Backups</h1>
<table>
  @foreach ($backups as $backup)
    <tr><td>{{ $backup }}</td><td>{{ link_to_route('simulation.restore', 'Restore', ['batch' => $backup]) }}</td></tr>
  @endforeach
</table>
@stop
