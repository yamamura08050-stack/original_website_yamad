


if(document.body.classList.contains('page-create')){

    document.addEventListener('DOMContentLoaded', function () {
        let exerciseIndex = 1; // 新しいexerciseのインデックス
        const exercisesContainer = document.getElementById('exercises-container');

        // 新しいExerciseを追加
        document.getElementById('add-exercise-btn').addEventListener('click', function () {
            const newExercise = document.createElement('div');
            newExercise.classList.add('exercise-block');
            newExercise.style.marginBottom = '15px';

            let options = '<option value="">-- Search History --</option>';
            exercises.forEach(exercise => {
                options += `<option value="${exercise}">${exercise}</option>`;
            });



            newExercise.innerHTML = `
            <div class="exercise-label">
                <label>Exercise</label>
                <input type="text" name="name[]">
                <select class="exercise-select" name="name[]">
                    ${options}
                    @endforeach
                </select>

            </div>
            <div class="sets-container">
                <div class="set-row">
                    <input type="number" name="weight[${exerciseIndex}][]" placeholder="weight(kg)">
                    <input type="number" name="reps[${exerciseIndex}][]" placeholder="reps">
                    <button type="button" class="add-set">+</button>
                </div>
            </div>
        `;
            exercisesContainer.appendChild(newExercise);
            exerciseIndex++;
        });

        // set追加 / 削除
        exercisesContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-set')) {
                const setsContainer = e.target.closest('.sets-container');
                const parentIndex = Array.from(exercisesContainer.children).indexOf(e.target.closest('.exercise-block'));

                const newSet = document.createElement('div');
                newSet.classList.add('set-row');
                newSet.innerHTML = `
                <input type="number" name="weight[${parentIndex}][]" placeholder="weight(kg)">
                <input type="number" name="reps[${parentIndex}][]" placeholder="reps">
                <button type="button" class="remove-set">ー</button>
            `;
                setsContainer.appendChild(newSet);
            }

            if (e.target.classList.contains('remove-set')) {
                e.target.parentElement.remove();
            }
        });

        document.querySelectorAll('.exercise-select').forEach(select => {
            select.addEventListener('change', function () {
                const label = this.closest('.exercise-label');
                if (!label) return;

                const input = label.querySelector('.exercise-input');
                if (!input) return;

                if (this.value) {
                    input.value = '';
                    input.disabled = true;
                } else {
                    input.disabled = false;
                }
            });
        });



    });
}


if ($('body').hasClass('page-edit')) {
    $(function () {
        const $setsContainer = $('.sets-container');

        if (!$setsContainer.length) return; 

        $setsContainer.on('click', '.add-set', function () {
            const $newSet = $(`
                <div class="set-row">
                    <input type="number" name="weight[]" placeholder="weight(kg)">
                    <input type="number" name="reps[]" placeholder="reps">
                    <button type="button" class="remove-set">-</button>
                </div>
            `);
            $setsContainer.append($newSet);
        });

        $setsContainer.on('click', '.remove-set', function () {
            $(this).parent().remove();
        });
    });
}


