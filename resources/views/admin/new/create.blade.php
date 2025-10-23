@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<style>
:root{
  --bg:#f6f8fb; --card:#ffffff; --ink:#0f172a; --muted:#64748b;
  --primary:#5b6cff; --primary-600:#4959f2; --ring:rgba(91,108,255,.22);
  --border:#e6e8ef; --shadow:0 12px 30px rgba(15,23,42,.06); --red:#ef4444;
}
body{background:var(--bg)}
.fx-wrap{max-width:680px;margin:0 auto;padding:28px 16px}
.fx-header{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:18px}
.fx-title{font:800 40px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.025em}
.fx-back{display:inline-flex;align-items:center;gap:10px;color:var(--muted);text-decoration:none;font-weight:700}
.fx-back:hover{color:var(--ink)}
.fx-card{background:var(--card);border:1px solid var(--border);border-radius:22px;box-shadow:var(--shadow);padding:24px}
.fx-label{display:block;font-weight:800;color:var(--ink);margin:0 0 8px 2px;font-size:14px}
.fx-input{width:100%;background:#fff;border:1px solid var(--border);border-radius:12px;padding:12px 14px;color:#111827;outline:none;transition:.16s border-color,.16s box-shadow}
.fx-input:focus{border-color:var(--primary);box-shadow:0 0 0 6px var(--ring)}
.fx-hint{font-size:12px;color:var(--muted);margin-top:6px}

/* file input */
.fx-file{position:relative}
.fx-file-input{ /* invisible input fully covering the UI */
  position:absolute; inset:0; width:100%; height:100%;
  opacity:0; cursor:pointer; z-index:3;
}
.fx-file .fx-file-ui{
  position:relative; z-index:2;
  height:46px; border:1px dashed var(--border); border-radius:12px;
  background:#fafbff; display:flex; align-items:center; gap:10px;
  padding:0 12px; color:var(--muted); font-weight:700;
}
.fx-file .fx-chip{padding:6px 12px;border-radius:10px;background:var(--primary);color:#fff;font-weight:800;font-size:12px}
.fx-counter{font-size:12px;font-weight:800;color:#334155;margin-left:6px}

/* preview */
.fx-previews{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-top:10px}
.fx-prev{position:relative;border:1px solid var(--border);border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 6px 16px rgba(2,6,23,.06)}
.fx-prev img{display:block;width:100%;height:180px;object-fit:cover}
.fx-prev .fx-remove{position:absolute;top:8px;right:8px;background:#fff;color:var(--red);border:1px solid #fecaca;border-radius:10px;padding:4px 8px;font-weight:800;font-size:12px;cursor:pointer;box-shadow:0 2px 6px rgba(15,23,42,.15)}

/* CTA */
.fx-actions{display:flex;gap:12px;flex-wrap:wrap}
.fx-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 18px;border-radius:12px;border:1px solid transparent;font-weight:900;color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary-600));box-shadow:0 8px 18px rgba(91,108,255,.25)}
</style>

<div class="fx-wrap">
  <div class="fx-header">
    <h3 class="fx-title">{{ isset($item) ? 'Edit “What’s New” Item' : 'Add “What’s New” Item' }}</h3>
    <a class="fx-back" href="{{ route('admin.new.index') }}">← Back</a>
  </div>

  @if ($errors->any())
    <div style="border-radius:12px;border:1px solid #fecaca;background:#fef2f2;color:#7f1d1d;padding:12px 14px;margin-bottom:16px">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $error) <li style="font-size:14px">{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form id="wnForm" method="POST" enctype="multipart/form-data"
        action="{{ isset($item) ? route('admin.new.update',$item->id) : route('admin.new.store') }}"
        class="fx-card">
    @csrf
    @if(isset($item)) @method('PUT') @endif

    <div class="fx-row" style="display:grid;gap:16px">
      <div>
        <label class="fx-label">Title <span style="color:#ef4444">*</span></label>
        <input class="fx-input" type="text" name="title" required
               placeholder="e.g. Ready To Wear" value="{{ old('title', $item->title ?? '') }}">
      </div>

      <div class="fx-file">
        <label class="fx-label">
          Image <small>(max 1)</small> <span id="fxCount" class="fx-counter"></span>
        </label>

        <!-- label is clickable; input also covers entire area (fixes your click issue) -->
        <label for="imageInput" class="fx-file-ui">
          <span class="fx-chip">Choose file</span><span>JPG/PNG/WEBP up to 4MB</span>
        </label>
        <input id="imageInput" class="fx-file-input" type="file" name="image" accept="image/*">

        <div id="previewContainer" class="fx-previews">
          @if(isset($item) && $item->image)
            <div class="fx-prev" id="existingPrev">
              <img src="{{ asset('storage/'.$item->image) }}" alt="Current image">
              <button type="button" class="fx-remove" id="removeExistingBtn">Remove</button>
            </div>
            <input type="hidden" name="remove_image" id="removeExisting" value="0">
            <div class="fx-hint" style="grid-column:1/-1">Leave as-is to keep current image, or click <b>Remove</b> and upload a new one.</div>
          @endif
        </div>

        <div id="fxMsg" class="fx-hint"></div>
      </div>
    </div>

    <div class="fx-actions" style="margin-top:20px">
      <button class="fx-btn" type="submit">{{ isset($item) ? 'Update' : 'Save' }}</button>
      <a href="{{ route('admin.new.index') }}" class="fx-back" style="padding:12px 16px;border:1px solid var(--border);border-radius:12px;background:#fff;font-weight:900">Cancel</a>
    </div>
  </form>
</div>

<script>
/** Single-image preview + replace (create & edit). */
(function () {
  const MAX = 1;
  const input   = document.getElementById('imageInput');
  const preview = document.getElementById('previewContainer');
  const msg     = document.getElementById('fxMsg');
  const counter = document.getElementById('fxCount');

  function updateCounter(has){ counter.textContent = `(${has ? 1 : 0}/${MAX})`; }
  function clearPreview(){ preview.querySelectorAll('.fx-prev:not(#existingPrev)').forEach(n=>n.remove()); updateCounter(false); }

  function renderPreview(file){
    // remove any new preview first
    clearPreview();
    const card = document.createElement('div');
    card.className = 'fx-prev';

    const img = document.createElement('img');
    card.appendChild(img);

    const rm = document.createElement('button');
    rm.type = 'button'; rm.className = 'fx-remove'; rm.textContent = 'Remove';
    rm.addEventListener('click', () => { input.value=''; card.remove(); updateCounter(false); });
    card.appendChild(rm);

    const reader = new FileReader();
    reader.onload = e => (img.src = e.target.result);
    reader.readAsDataURL(file);

    preview.prepend(card);
    updateCounter(true);
  }

  input?.addEventListener('change', e => {
    const file = (e.target.files || [])[0];
    if(!file){ clearPreview(); return; }
    if(!file.type.startsWith('image/')){ msg.textContent='Please choose a valid image file.'; input.value=''; clearPreview(); return; }
    msg.textContent='';
    renderPreview(file);
  });

  // edit mode: remove existing toggler
  const rmBtn = document.getElementById('removeExistingBtn');
  const rmFlag= document.getElementById('removeExisting');
  rmBtn?.addEventListener('click', () => {
    document.getElementById('existingPrev')?.remove();
    if(rmFlag) rmFlag.value = '1';
    updateCounter(!!input?.files?.length);
  });

  // init
  updateCounter(!!document.getElementById('existingPrev'));
})();
</script>
@endsection
