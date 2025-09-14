document.addEventListener('DOMContentLoaded', function () {
    const dates = document.querySelectorAll('.date');
    const selectedInput = document.getElementById('selected-date');

    // 今日の日付を取得（YYYY-MM-DD形式）
    const today = new Date().toISOString().split('T')[0];

    dates.forEach(el => {
        // 初期表示で今日の日付を選択状態にする
        if (el.dataset.date === today) {
            el.classList.add('selected');
            selectedInput.value = today;
        }

        // クリックイベント
        el.addEventListener('click', function () {
            // まず全ての.selectedクラスを外す
            dates.forEach(d => d.classList.remove('selected'));

            // クリックした要素に.selectedクラスを付ける
            this.classList.add('selected');

            // hidden input に日付を保存
            selectedInput.value = this.dataset.date;

            console.log("選択した日付:", this.dataset.date);
        });
    });
});


document.getElementById('add-exercise-btn').addEventListener('click', function () {
    const selectedDate = document.getElementById('selected-date').value;
    if (selectedDate) {
        window.location.href = '/workouts/create?date=' + selectedDate;
    } else {
        alert("Select a date");
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
