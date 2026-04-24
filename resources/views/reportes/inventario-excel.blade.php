@extends('layouts.app')

@section('title', 'Generar Reportes')

@section('content')
<div class="page-header">
    <h1>📊 Reportes de Equipos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Reportes</li>
        </ol>
    </nav>
</div>

<div class="table-container mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0" style="font-weight: 600; color: #1f2937;">
            <i class="bi bi-file-earmark-text me-2"></i>Generar Reportes de Inventario
        </h5>

        <div>
            <a href="{{ route('reportes.exportExcel') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Exportar a Excel
            </a>
            <a href="{{ route('reportes.exportPDF') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Exportar a PDF
            </a>
        </div>
    </div>
</div>
@endsection
    