@extends('layouts.app')

@section('content')
<style>
:root{
  --bg:#f6f8fb; --card:#ffffff; --ink:#0f172a; --muted:#64748b;
  --primary:#5b6cff; --primary-600:#4959f2; --ring:rgba(91,108,255,.22);
  --border:#e6e8ef; --shadow:0 12px 30px rgba(15,23,42,.06);
  --red:#ef4444;
}
body{background:var(--bg)}
.fx-wrap{max-width:980px;margin:0 auto;padding:28px 16px}
.fx-header{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:18px}
.fx-title{font:800 46px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.025em}
.fx-back{display:inline-flex;align-items:center;gap:10px;color:var(--muted);text-decoration:none;font-weight:700}
.fx-back:hover{color:var(--ink)}
.fx-card{background:var(--card);border:1px solid var(--border);border-radius:22px;box-shadow:var(--shadow);padding:24px}
.fx-grid{display:grid;gap:22px}
@media (min-width:900px){.fx-grid{grid-template-columns:1.1fr .9fr}}
.fx-label{display:block;font-weight:800;color:var(--ink);margin:0 0 8px 2px;font-size:14px}
.fx-hint{font-size:12px;color:var(--muted);margin-top:6px}
.fx-row{display:grid;gap:16px}
@media (min-width:680px){.fx-row.fx-2{grid-template-columns:1fr 1fr}}
.fx-input,.fx-textarea{width:100%;background:#fff;border:1px solid var(--border);border-radius:12px;padding:12px 14px;color:#111827;outline:none;transition:.16s border-color,.16s box-shadow}
.fx-input:focus,.fx-textarea:focus{border-color:var(--primary);box-shadow:0 0 0 6px var(--ring)}
.fx-textarea{min-height:160px;resize:vertical}

/* switch */
.fx-switch{display:flex;align-items:center;gap:10px}
.fx-switch input{appearance:none;width:42px;height:24px;border-radius:999px;background:#e5e7eb;position:relative;cursor:pointer;transition:.2s}
.fx-switch input:checked{background:rgba(27,197,114,.15);box-shadow:inset 0 0 0 2px rgba(27,197,114,.25)}
.fx-switch input::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:999px;background:#fff;box-shadow:0 2px 6px rgba(15,23,42,.15);transition:.2s transform}
.fx-switch input:checked::after{transform:translateX(18px)}
.fx-switch label{font-weight:700;color:var(--ink);font-size:14px}

/* file input */
.fx-file{position:relative}
.fx-file input[type=file]{width:100%;opacity:0;height:46px;position:absolute;inset:0;cursor:pointer}
.fx-file .fx-file-ui{height:46px;border:1px dashed var(--border);border-radius:12px;background:#fafbff;display:flex;align-items:center;gap:10px;padding:0 12px;color:var(--muted);font-weight:700}
.fx-file .fx-chip{padding:6px 12px;border-radius:10px;background:var(--primary);color:#fff;font-weight:800;font-size:12px}
.fx-counter{font-size:12px;font-weight:800;color:#334155;margin-left:6px}

/* previews */
.fx-previews{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-top:10px}
.fx-prev{position:relative;border:1px solid var(--border);border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 6px 16px rgba(2,6,23,.06)}
.fx-prev img{display:block;width:100%;height:140px;object-fit:cover}
.fx-prev .fx-remove{position:absolute;top:8px;right:8px;background:#fff;color:var(--red);border:1px solid #fecaca;border-radius:10px;padding:4px 8px;font-weight:800;font-size:12px;cursor:pointer;box-shadow:0 2px 6px rgba(15,23,42,.15)}
.fx-note{font-size:12px;color:var(--muted);margin-top:6px}

/* CTA */
.fx-actions{display:flex;gap:12px;flex-wrap:wrap}
.fx-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 18px;border-radius:12px;border:1px solid transparent;font-weight:900;color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary-600));box-shadow:0 8px 18px rgba(91,108,255,.25)}
</style>

<div class="fx-wrap">
  <div class="fx-header">
    <h1 class="fx-title">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>
    <a class="fx-back" href="{{ route('admin.products.index') }}">← Back</a>
  </div>

  @if ($errors->any())
    <div style="border-radius:12px;border:1px solid #fecaca;background:#fef2f2;color:#7f1d1d;padding:12px 14px;margin-bottom:16px">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $error)
          <li style="font-size:14px">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form id="productForm" method="POST" enctype="multipart/form-data"
        action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
        class="fx-card">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="fx-grid">
      <!-- LEFT -->
      <div>
        <div class="fx-row">
          <div>
            <label class="fx-label">Product Name <span style="color:#ef4444">*</span></label>
            <input class="fx-input" type="text" name="name" required value="{{ old('name', $product->name ?? '') }}">
          </div>
          <div>
            <label class="fx-label">Description</label>
            <textarea class="fx-textarea" name="description" placeholder="Short description...">{{ old('description', $product->description ?? '') }}</textarea>
          </div>

          <div class="fx-row fx-2">
            <div>
              <label class="fx-label">Final Price (shown)</label>
              <input class="fx-input" type="number" name="final_price" step="0.01" min="0" required value="{{ old('final_price', $product->final_price ?? '') }}">
            </div>
            <div>
              <label class="fx-label">Original Price</label>
              <input class="fx-input" type="number" name="original_price" step="0.01" min="0" value="{{ old('original_price', $product->original_price ?? '') }}">
              <p class="fx-hint">Displayed with a strike-through when higher than Final Price.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div>
        <div class="fx-row">

          <!-- NEW: Pieces & Collection -->
          <div class="fx-row fx-2">
            <div>
              <label class="fx-label">Pieces <span style="color:#ef4444">*</span></label>
              <select class="fx-input" name="pieces" required>
                <option value="2-piece" {{ old('pieces', $product->pieces ?? '') === '2-piece' ? 'selected' : '' }}>2 Piece</option>
                <option value="3-piece" {{ old('pieces', $product->pieces ?? '') === '3-piece' ? 'selected' : '' }}>3 Piece</option>
              </select>
            </div>
            <div>
              <label class="fx-label">Collection <span style="color:#ef4444">*</span></label>
              <select class="fx-input" name="collection" required>
                <option value="summer" {{ old('collection', $product->collection ?? '') === 'summer' ? 'selected' : '' }}>Summer</option>
                <option value="winter" {{ old('collection', $product->collection ?? '') === 'winter' ? 'selected' : '' }}>Winter</option>
                <option value="spring" {{ old('collection', $product->collection ?? '') === 'spring' ? 'selected' : '' }}>Spring</option>
              </select>
            </div>
          </div>
          <!-- /NEW -->

          <div>
            <label class="fx-label">Stock</label>
            <input class="fx-input" type="number" name="stock" min="0" required value="{{ old('stock', $product->stock ?? 0) }}">
          </div>

          <div class="fx-switch">
            <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) >
            <label for="is_active">Available (Active)</label>
          </div>

          <div class="fx-file">
            <label class="fx-label">Upload Images <small>(max 3)</small> <span id="fxCount" class="fx-counter"></span></label>
            <div class="fx-file-ui">
              <span class="fx-chip">Choose files</span><span>JPG/PNG/WEBP up to 4MB each</span>
            </div>
            <input id="imagesInput" type="file" name="images[]" multiple accept="image/*">
            <div id="previewContainer" class="fx-previews"></div>
            <div id="fxMsg" class="fx-note"></div>
          </div>

          @php $existingImages = isset($product) && is_array($product->images) ? $product->images : []; @endphp
          
            <div>
              <label class="fx-label">Current Images</label>
              <div class="fx-previews">
                @foreach($existingImages as $img)
                  <div class="fx-prev">
                    <img src="{{ Storage::disk('public')->url($img) }}" alt="image">
                    <div style="display:flex;align-items:center;gap:8px;padding:8px 10px">
                      <input class="fx-exist" type="checkbox" name="remove_images[]" id="rm_{{ md5($img) }}" value="{{ $img }}">
                      <label for="rm_{{ md5($img) }}" style="font-weight:700;color:#0f172a;font-size:13px">Remove</label>
                    </div>
                  </div>
                @endforeach
              </div>
              <p class="fx-note">Total kept images after save will be up to 3 (existing + new).</p>
            
          @endif
        </div>
      </div>
    </div>

    <div class="fx-actions" style="margin-top:20px">
      <button class="fx-btn">{{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
    </div>
  </form>
</div>

<script>
/**
 * Accumulative previews + input files.
 * - Selecting more files ADDS to previous selection (until MAX).
 * - Shows all selected previews (1st, then 1st+2nd, then 1st+2nd+3rd).
 * - Keeps in sync with <input> via DataTransfer so all chosen files upload.
 * - Respects existing images kept/removed when computing remaining slots.
 */
(function () {
  const MAX = 3;

  const form    = document.getElementById('productForm');
  const input   = document.getElementById('imagesInput');
  const preview = document.getElementById('previewContainer');
  const msg     = document.getElementById('fxMsg');
  const counter = document.getElementById('fxCount');

  if (!form || !input || !preview) return;

  // Keep an internal list of newly added files (persist across changes)
  let selectedNewFiles = [];

  const existingBoxes = () => Array.from(document.querySelectorAll('.fx-exist'));
  const keptExisting  = () => existingBoxes().reduce((n, cb) => n + (cb.checked ? 0 : 1), 0);

  function syncInputFiles() {
    const dt = new DataTransfer();
    selectedNewFiles.forEach(f => dt.items.add(f));
    input.files = dt.files; // update the real input for submission
  }

  function updateCounter() {
    const total = keptExisting() + selectedNewFiles.length;
    counter.textContent = `(${total}/${MAX})`;
    msg.textContent = total > MAX ? 'Max 3 images total (existing + new).' : '';
  }

  function renderPreviews() {
    // Re-render ALL new previews (do not clear existing section)
    preview.innerHTML = '';
    selectedNewFiles.forEach((file, idx) => {
      const card = document.createElement('div');
      card.className = 'fx-prev';

      const img = document.createElement('img');
      card.appendChild(img);

      const rm = document.createElement('button');
      rm.type = 'button';
      rm.className = 'fx-remove';
      rm.textContent = 'Remove';
      rm.addEventListener('click', () => {
        // Remove by index and refresh everything
        selectedNewFiles.splice(idx, 1);
        syncInputFiles();
        renderPreviews();
        updateCounter();
      });
      card.appendChild(rm);

      const reader = new FileReader();
      reader.onload = e => (img.src = e.target.result);
      reader.readAsDataURL(file);

      preview.appendChild(card);
    });
  }

  function remainingSlots() {
    return Math.max(0, MAX - keptExisting() - selectedNewFiles.length);
  }

  // If user toggles remove on existing images, recalc remaining and enforce MAX
  existingBoxes().forEach(cb =>
    cb.addEventListener('change', () => {
      // If we now exceed MAX (because we re-kept an existing), trim selectedNewFiles
      while (keptExisting() + selectedNewFiles.length > MAX) {
        selectedNewFiles.pop();
      }
      syncInputFiles();
      renderPreviews();
      updateCounter();
    })
  );

  input.addEventListener('change', e => {
    const files = Array.from(e.target.files || []);
    let canTake = remainingSlots();

    for (const f of files) {
      if (canTake <= 0) break;
      if (!f || !f.type || !f.type.startsWith('image/')) continue;

      // Avoid duplicate by name+size+lastModified (simple heuristic)
      const dup = selectedNewFiles.some(x =>
        x.name === f.name && x.size === f.size && x.lastModified === f.lastModified
      );
      if (dup) continue;

      selectedNewFiles.push(f);
      canTake--;
    }

    // After consuming, reset the chooser so the same file can be picked again later if removed
    e.target.value = '';

    syncInputFiles();
    renderPreviews();
    updateCounter();
  });

  // init
  updateCounter();
})();
</script>

@endsection
