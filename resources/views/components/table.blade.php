<!-- views/components/table.blade.php tablas reutilizables
    se maneja directamente desde el JS para llenarla dinámicamente. GLOBAL -->
<table id="{{ $id }}">
    <thead>
        <tr>
            @foreach($columns as $col)
            <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
                <!-- JS llenará dinámicamente -->
    </tbody>
</table>
