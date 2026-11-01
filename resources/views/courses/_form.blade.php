@csrf
<label for="code">Course code</label>
<input id="code" name="code" value="{{ old('code', $course->code) }}" required>

<label for="title">Title</label>
<input id="title" name="title" value="{{ old('title', $course->title) }}" required>

<label for="credits">Credits</label>
<input id="credits" type="number" min="1" max="10" name="credits" value="{{ old('credits', $course->credits ?? 3) }}" required>

<label for="lecturer_id">Lecturer</label>
<select id="lecturer_id" name="lecturer_id">
    <option value="">-- Unassigned --</option>
    @foreach ($lecturers as $lecturer)
        <option value="{{ $lecturer->id }}" @selected(old('lecturer_id', $course->lecturer_id) == $lecturer->id)>
            {{ $lecturer->name }}
        </option>
    @endforeach
</select>

<label for="description">Description</label>
<textarea id="description" name="description" rows="4">{{ old('description', $course->description) }}</textarea>

<p style="margin-top:16px">
    <button class="btn" type="submit">Save</button>
    <a class="btn btn-secondary" href="{{ route('courses.index') }}">Cancel</a>
</p>
