
@csrf

<label for="name">Full name</label>
<input id="name" name="name"
       value="{{ old('name', optional($student->user)->name) }}" required>

@error('name')
    <span class="text-danger">{{ $message }}</span>
@enderror


<label for="email">Email</label>
<input id="email" type="email" name="email"
       value="{{ old('email', optional($student->user)->email) }}" required>

@error('email')
    <span class="text-danger">{{ $message }}</span>
@enderror


<label for="student_number">Student number</label>
<input id="student_number" name="student_number"
       value="{{ old('student_number', $student->student_number) }}" required>

@error('student_number')
    <span class="text-danger">{{ $message }}</span>
@enderror


<label for="programme">Programme</label>
<input id="programme" name="programme"
       value="{{ old('programme', $student->programme) }}" required>

@error('programme')
    <span class="text-danger">{{ $message }}</span>
@enderror


<p style="margin-top:16px">
    <button class="btn" type="submit">Save</button>
    <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
</p>

