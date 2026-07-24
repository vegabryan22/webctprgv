@extends('layouts.admin')
@section('title', 'Noticias')
@section('content')
<div class="page-heading">
    <div><h1><i class="fa-regular fa-newspaper"></i> Noticias</h1><p class="muted">Comunicados y publicaciones del sitio institucional.</p></div>
    <div class="actions">
        <a class="button ghost" href="{{ route('news') }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver noticias</a>
        @if(auth()->user()->hasPermission('news.manage'))<a class="button ghost" href="{{ route('admin.news-categories.index') }}"><i class="fa-solid fa-tags"></i> Categorías</a><a class="button" href="{{ route('admin.news.create') }}"><i class="fa-solid fa-circle-plus"></i> Nueva noticia</a>@endif
    </div>
</div>
<form class="filter-bar" method="GET"><label for="status">Estado</label><select id="status" name="status" onchange="this.form.submit()"><option value="">Todos</option><option value="draft" @selected(request('status') === 'draft')>Borrador</option><option value="published" @selected(request('status') === 'published')>Publicado</option></select></form>
<div class="card table-wrap"><table><thead><tr><th>Noticia</th><th>Categoría</th><th>Publicación</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>
@forelse($articles as $article)
<tr>
    <td><strong>{{ $article->title }}</strong>@if($article->is_featured) <span class="badge success">Destacada</span>@endif<br><small class="muted">{{ $article->summary }}</small></td>
    <td><span class="badge" style="border-left:4px solid {{ $article->category->color }}">{{ $article->category->name }}</span></td>
    <td>{{ $article->published_at?->translatedFormat('d M Y H:i') ?: 'Sin publicar' }}@if($article->expires_at)<br><small class="muted">Expira {{ $article->expires_at->translatedFormat('d M Y') }}</small>@endif</td>
    <td><span class="badge {{ $article->status === 'published' ? 'success' : 'warning' }}">{{ $article->status === 'published' ? 'Publicado' : 'Borrador' }}</span></td>
    <td><div class="actions">@if($article->status === 'published')<a class="button link" href="{{ route('news.show', $article) }}" target="_blank"><i class="fa-solid fa-eye"></i> Ver</a>@endif @if(auth()->user()->hasPermission('news.manage'))<a class="button link" href="{{ route('admin.news.edit', $article) }}"><i class="fa-solid fa-pen"></i> Editar</a><form method="POST" action="{{ route('admin.news.destroy', $article) }}" onsubmit="return confirm('¿Eliminar definitivamente esta noticia?')">@csrf @method('DELETE')<button class="button link" type="submit"><i class="fa-regular fa-trash-can"></i> Eliminar</button></form>@endif</div></td>
</tr>
@empty<tr><td colspan="5">Todavía no hay noticias. Las publicaciones demostrativas anteriores ya no se muestran.</td></tr>@endforelse
</tbody></table>{{ $articles->links('pagination.admin') }}</div>
@endsection
