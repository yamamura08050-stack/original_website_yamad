//カレンダーで選んだ日付をselectedDateに保存
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.date').forEach(el => {
        el.addEventListener('click', function () {
            let selectedDate = this.dataset.date;
            document.getElementById('selected-date').value = selectedDate;
            console.log("選択した日付:", selectedDate);
        });
    });
});

document.getElementById('add-exercise-btn').addEventListener('click', function () {
    const selectedDate = document.getElementById('selected-date').value;
    if (selectedDate) {
        window.location.href = '/workouts/create?date=' + selectedDate;
    } else {
        alert("日付を選んでください");
    }
});


document.querySelectorAll('.date').forEach(el => {
    el.addEventListener('click', function () {
        const selectedDate = this.dataset.date;

        fetch('/workouts/day?date=' + selectedDate)
            .then(res => res.json())
            .then(data => {
                const container = document.querySelector('.exercise-list');
                container.innerHTML = ''; // 既存の中身をクリア

                if (data.length === 0) {
                    container.innerHTML = '<p>No exercises for this date.</p>';
                } else {
                    data.forEach(ex => {
                        const div = document.createElement('div');
                        div.classList.add('exercise-item');
                        div.dataset.id = ex.id;
                        
                        div.innerHTML = `
                            <a href="/workouts/${ex.id}/edit">
                                <span class="exercise-name">${ex.exercise_name}</span>
                                <span class="exercise-sets">Sets: ${ex.logs_count}</span>
                            </a>
                            <button type="button" class="remove-exercise">-</button>
                        `;
                        container.appendChild(div);
                    });
                }
            });
    });
});

const  container = document.querySelector('.exercise-list');

container.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-exercise')){
        const exerciseId = e.target.parentElement.dataset.id;
        
        console.log('削除対象の exerciseId:', exerciseId);

        fetch(`/workouts/${exerciseId}`,{
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                e.target.parentElement.remove();

            }else{
                console.log('削除エラー:', data.message);
                alert('Failed to delete: ' + data.message);
            }
        });
    }
});
