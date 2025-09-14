

const csrfToken = $('meta[name="csrf-token"]').attr('content');



const renderHistory = (weightData) => {
    const { id, record_date, weight, diff } = weightData;

    // 日付をアメリカ式に変換
    const dateObj = new Date(record_date);
    const options = { year: 'numeric', month: 'short', day: 'numeric' }; // Sep 4, 2025
    const formattedDate = dateObj.toLocaleDateString('en-US', options);

    return `
        <div class="history-item" data-id="${id}" data-date="${record_date}">
            <div class="date">${formattedDate}</div>
            <div class="weight">${weight}kg</div>
            <div class="diff">
                <span class="diff-text">${diff}</span>
                <form class="delete-form" action="/weight/${id}" method="POST" style="display:inline;">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="delete-btn" type="submit" style="display:none;">－</button>
                </form>
            </div>
        </div>
    `;
};

// グラフ更新関数
const updateChart = () => {
    const labels = [];
    const data = [];

    $('.history-item').each(function () {
        labels.push($(this).data('date'));
        data.push(parseFloat($(this).find('.weight').text()));
    });

    const ctx = document.getElementById('weight-chart').getContext('2d');

    if (window.weightChart) {
        // 既存グラフを更新
        window.weightChart.data.labels = labels;
        window.weightChart.data.datasets[0].data = data;
        window.weightChart.update();
    } else {
        // 初回描画
        window.weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Weight',
                    data: data,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: false, 
                plugins: {
                    legend: { display: true },
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'x', // 横方向のみスクロール
                        },
                        zoom: {
                            wheel: { enabled: true },
                            mode: 'x'
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Date' },
                        ticks: {
                            autoSkip: false,  
                            maxRotation: 0,  
                            minRotation: 0,
                            display:false,
                            font: { size: 12 } 
                        }
                        },
                    y: { title: { display: true, text: 'Weight (kg)' }, beginAtZero: false }
                }
            }
        });
    }
};

    


const addWeightToHistory = (weightData) => {
    const $historyList = $('.history-list');
    let existing = $(`.history-item[data-date='${weightData.record_date}']`);
    if (existing.length) {
        existing.replaceWith(renderHistory(weightData));
    } else {
        $historyList.prepend(renderHistory(weightData));
    }

    const items = $historyList.children('.history-item').get();

    items.sort((a, b) => {
        const dateA = new Date($(a).data('date'));
        const dateB = new Date($(b).data('date'));
        return dateB - dateA; // 新しい日付が上
    });

    $historyList.empty().append(items);
};

// 削除ボタン
$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    const $form = $(this).closest('form');
    const url = $form.attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: $form.serialize(),
        success: function (res) {
            if (res.success) {
                $form.closest('.history-item').remove();
                $('.delete-btn').hide();
            } else {
                alert('Failed to delete');
            }
        },
        error: function () {
            alert('Failed to delete');
        }
    });
});


// 新規追加 / 更新
$('#weight-form').on('submit', function (e) {
    e.preventDefault();
    

    $('.edit-form').hide();
    $('.delete-btn').hide();   // ← delete-btn を隠す
    $('.edit-btn').show(); 
    const record_date = $('#record-date').val();
    const weight = $('#record-weight').val();
    const token = $('input[name="_token"]').val();

    $.ajax({
        url: '/weight',
        method: 'POST',
        data: {
            _token: token,
            record_date: record_date,
            weight: weight
        },
        success: function (response) {
            if (response.success) {
                // updated に含まれる複数行（前後の日付も含む）を更新
                response.updated.forEach(function (row) {
                    addWeightToHistory(row); // 新規追加 or 上書き
                });

                // グラフ更新
                updateChart();
            }
        },

        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText);
            alert('Failed to save');
        }
    });
});

// 編集ボタンで削除ボタンの表示切替
$('#edit-btn').on('click', function () {
    $('.delete-btn').toggle();
});

    
