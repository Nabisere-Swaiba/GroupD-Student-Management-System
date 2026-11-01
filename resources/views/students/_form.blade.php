<<<<<<< HEAD

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

=======
@php $isEdit = isset($student); @endphp

<div class="form-grid">
    <div>
        <label for="student_number">Student number</label>
        <input id="student_number" type="text" name="student_number" required
               value="{{ old('student_number', $student->student_number ?? '') }}"
               class="{{ $errors->has('student_number') ? 'is-invalid' : '' }}">
        @error('student_number') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="programme">Programme</label>
        <input id="programme" type="text" name="programme"
               value="{{ old('programme', $student->programme ?? 'Bachelor of Business Computing') }}"
               class="{{ $errors->has('programme') ? 'is-invalid' : '' }}">
        @error('programme') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="first_name">First name</label>
        <input id="first_name" type="text" name="first_name" required
               value="{{ old('first_name', $student->first_name ?? '') }}"
               class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}">
        @error('first_name') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="last_name">Last name</label>
        <input id="last_name" type="text" name="last_name" required
               value="{{ old('last_name', $student->last_name ?? '') }}"
               class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}">
        @error('last_name') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="email">Email (also the login)</label>
        <input id="email" type="email" name="email" required
               value="{{ old('email', $student->email ?? '') }}"
               class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
        @error('email') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="phone">Phone</label>
        <input id="phone" type="text" name="phone"
               value="{{ old('phone', $student->phone ?? '') }}"
               class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
        @error('phone') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="date_of_birth">Date of birth</label>
        <input id="date_of_birth" type="date" name="date_of_birth"
               value="{{ old('date_of_birth', isset($student) ? $student->date_of_birth?->format('Y-m-d') : '') }}"
               class="{{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}">
        @error('date_of_birth') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="password">Password {{ $isEdit ? '(leave blank to keep current)' : '' }}</label>
        <input id="password" type="password" name="password" {{ $isEdit ? '' : 'required' }}
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
        @error('password') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
>>>>>>> 361d55930655e855bf2d633d39b5dd6de7c79180
