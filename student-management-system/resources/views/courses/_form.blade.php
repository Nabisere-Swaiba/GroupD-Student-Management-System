<div class="form-grid">
    <div>
        <label for="code">Course code</label>
        <input id="code" type="text" name="code" required value="{{ old('code', $course->code ?? '') }}"
               class="{{ $errors->has('code') ? 'is-invalid' : '' }}">
        @error('code') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="title">Title</label>
        <input id="title" type="text" name="title" required value="{{ old('title', $course->title ?? '') }}"
               class="{{ $errors->has('title') ? 'is-invalid' : '' }}">
        @error('title') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="credit_units">Credit units</label>
        <input id="credit_units" type="number" name="credit_units" min="1" max="10" required
               value="{{ old('credit_units', $course->credit_units ?? 3) }}"
               class="{{ $errors->has('credit_units') ? 'is-invalid' : '' }}">
        @error('credit_units') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="capacity">Capacity (max students)</label>
        <input id="capacity" type="number" name="capacity" min="1" max="500" required
               value="{{ old('capacity', $course->capacity ?? 50) }}"
               class="{{ $errors->has('capacity') ? 'is-invalid' : '' }}">
        @error('capacity') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="full">
        <label for="lecturer_id">Lecturer</label>
        <select id="lecturer_id" name="lecturer_id" class="{{ $errors->has('lecturer_id') ? 'is-invalid' : '' }}">
            <option value="">— Not assigned —</option>
            @foreach ($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}" @selected(old('lecturer_id', $course->lecturer_id ?? null) == $lecturer->id)>
                    {{ $lecturer->name }}
                </option>
            @endforeach
        </select>
        @error('lecturer_id') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="full">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
