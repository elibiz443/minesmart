// Add Modal functions
function openModal() { document.getElementById("form-modal").classList.remove("hidden"); }
function closeModal() { document.getElementById("form-modal").classList.add("hidden"); }

// Edit Course Modal functions
function openModal2(courseId, title, description, status) {
  const modal = document.getElementById('edit-form-modal');
  document.getElementById('edit_course_id').value = courseId;
  document.getElementById('edit_title').value = title;
  document.getElementById('edit_description').value = description;
  document.getElementById('edit_status').value = status;

  modal.classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.edit-course-button').forEach(button => {
    button.addEventListener('click', function (event) {
      event.stopPropagation();
      const courseId = this.dataset.courseId;
      const title = this.dataset.title;
      const description = this.dataset.description;
      const status = this.dataset.status;

      openModal2(courseId, title, description, status);
    });
  });
});

function closeModal2() {
  const modal = document.getElementById('edit-form-modal');
  modal.classList.add('hidden');
}

// Edit Unit Modal functions
function openModal3(id, title, description) {
  const modal = document.getElementById('edit-unit-modal');
  document.getElementById('edit_unit_id').value = id;
  document.getElementById('edit_unit_title').value = title;
  document.getElementById('edit_unit_description').value = description;

  modal.classList.remove('hidden');
}

document.querySelectorAll('.edit-button').forEach(button => {
  button.addEventListener('click', function(event) {
    event.stopPropagation();
    const id = this.dataset.unitId;
    const title = this.dataset.title;
    const description = this.dataset.description;

    openModal3(id, title, description);
  });
});

function closeModal3() {
  const modal = document.getElementById('edit-unit-modal');
  modal.classList.add('hidden');
}

function openModal4(unitId) {
  // Show the modal
  document.getElementById("lesson-form-modal").classList.remove("hidden");

  // Update the unit ID within the modal
  document.getElementById("modal-unit-id").value = unitId;
}

function closeModal4() {
  document.getElementById("lesson-form-modal").classList.add("hidden");
}

// Edit Lesson Modal functions
function openModal5(lessonId, title, description) {
  const modal = document.getElementById('edit-lesson-modal');
  document.getElementById('edit_lesson_id').value = lessonId;
  document.getElementById('edit_lesson_title').value = title;
  document.getElementById('edit_lesson_description').value = description;

  modal.classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.edit-lesson-button').forEach(button => {
    button.addEventListener('click', function (event) {
      event.stopPropagation();
      const lessonId = this.dataset.id;
      const title = this.dataset.title;
      const description = this.dataset.description;

      openModal5(lessonId, title, description);
    });
  });
});

function closeModal5() {
  const modal = document.getElementById('edit-lesson-modal');
  modal.classList.add('hidden');
}

// Edit Checklist
function openModal6(id, engineOil, waterLevel, radiatorAir, airFilter, cabinClean, hydraulicOil, checkDate, checklistDateId) {

  console.log("Edit modal data:", {
  id, checklistDateId, checkDate,
  engineOil, waterLevel, radiatorAir,
  airFilter, cabinClean, hydraulicOil
});

  const modal = document.getElementById('edit-checklist-modal');
  document.getElementById('edit_checklist_id').value = id;
  document.getElementById('edit_checklist_date_id').value = checklistDateId;
  document.getElementById('edit_engine_oil_level').value = engineOil;
  document.getElementById('edit_water_level_radiator').value = waterLevel;
  document.getElementById('edit_radiator_air_blowing').value = radiatorAir;
  document.getElementById('edit_hydraulic_oil_level').value = hydraulicOil;

  const airFilterSelect = document.getElementById('edit_air_filter_cleaning');
  if (airFilterSelect) airFilterSelect.value = airFilter === '1' || airFilter === 'TRUE' ? 'TRUE' : 'FALSE';

  const cabinCleanSelect = document.getElementById('edit_cabin_cleanliness');
  if (cabinCleanSelect) cabinCleanSelect.value = cabinClean === '1' || cabinClean === 'TRUE' ? 'TRUE' : 'FALSE';

  document.getElementById('edit_check_date').value = checkDate ? checkDate.split(' ')[0] : '';
  disableWeekendDates('edit_check_date');
  modal.classList.remove('hidden');
}

function disableWeekendDates(dateInputId) {
  const dateInput = document.getElementById(dateInputId);
  if (!dateInput) return;
  dateInput.addEventListener('change', function () {
    const selectedDate = new Date(this.value);
    const day = selectedDate.getUTCDay();
    if (day === 0 || day === 6) {
      this.value = '';
      alert('Weekends are not allowed for checklist dates. Please select a weekday.');
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.edit-checklist-button').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      const id = this.dataset.id;
      const engineOil = this.dataset.engineOilLevel;
      const waterLevel = this.dataset.waterLevelRadiator;
      const radiatorAir = this.dataset.radiatorAirBlowing;
      const airFilter = this.dataset.airFilterCleaning;
      const cabinClean = this.dataset.cabinCleanliness;
      const hydraulicOil = this.dataset.hydraulicOilLevel;
      const checkDate = this.dataset.checkDate;
      const checklistDateId = this.dataset.checklistDateId;
      openModal6(id, engineOil, waterLevel, radiatorAir, airFilter, cabinClean, hydraulicOil, checkDate, checklistDateId);
    });
  });

  document.getElementById('closeModal6Button').addEventListener('click', closeModal6);
  document.getElementById('edit-checklist-modal').addEventListener('click', function (e) {
    if (e.target === this) closeModal6();
  });
});

function closeModal6() {
  document.getElementById('edit-checklist-modal').classList.add('hidden');
}

// Edit Chapter
function openAddChapterModal(lessonId) {
  const modal = document.getElementById('add-chapter-modal');
  document.getElementById('add_chapter_lesson_id').value = lessonId;
  
  // Clear form fields when opening the modal
  document.getElementById('add_chapter_title').value = '';

  modal.classList.remove('hidden');
}

function closeAddChapterModal() {
  const modal = document.getElementById('add-chapter-modal');
  modal.classList.add('hidden');
}

function updateFileName() {
  const input = document.getElementById('imageUpload');
  const label = document.getElementById('imageLabel');
  
  if (input.files.length > 0) {
    label.textContent = `🖼️ - ${input.files[0].name}`;
  } else {
    label.textContent = "🖼️ - No file chosen";
  }
}
