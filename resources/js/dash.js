
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let tdeechart = null; 


const weekCalRate = (x) => {

    let loss025kg = 100 - 27500 / x;
    let loss05kg = 100 - 55000 / x;
    let loss1kg = 100 - 110000 / x;

    let gain025kg = 100 + 27500 / x;
    let gain05kg = 100 + 55000 / x;
    let gain1kg = 100 + 110000 / x; 


    let mildLossCal = x * (loss025kg / 100);
    let lossCal = x * (loss05kg / 100);
    let extremeLossCal = x * (loss1kg / 100);

    let mildGainCal = x * (gain025kg / 100);
    let gainCal = x * (gain05kg / 100);
    let fastGainCal = x * (gain1kg / 100);

    $("#mild-loss-cal")
    $('#mild-loss-cal').text(mildLossCal.toFixed(0))
    $('#mild-loss-cal').next("small").text(loss025kg.toFixed(0) + "%");

    $("#loss-cal")
    $('#loss-cal').text(lossCal.toFixed(0))
    $('#loss-cal').next("small").text(loss05kg.toFixed(0) + "%");

    $("#extreme-loss-cal")
    $('#extreme-loss-cal').text(extremeLossCal.toFixed(0))
    $('#extreme-loss-cal').next("small").text(loss1kg.toFixed(0) + "%");

    $("#mild-gain-cal")
    $('#mild-gain-cal').text(mildGainCal.toFixed(0))
    $('#mild-gain-cal').next("small").text(gain025kg.toFixed(0) + "%");

    $("#gain-cal")
    $('#gain-cal').text(gainCal.toFixed(0))
    $('#gain-cal').next("small").text(gain05kg.toFixed(0) + "%");

    $("#fast-gain-cal")
    $('#fast-gain-cal').text(fastGainCal.toFixed(0))
    $('#fast-gain-cal').next("small").text(gain1kg.toFixed(0) + "%");
};

$(document).ready(function(){
    console.log("dash.js loaded and DOM ready");
/*TDEEの計算*/
    $(".calc").on("click", function (e) {
        e.preventDefault();

        let gender = $("#gender").val();
        let age = parseFloat($("#age").val());
        let wei = parseFloat($("#wei").val());
        let height = parseFloat($("#height").val());
        let activityLevel = parseFloat($("#activity-level").val());
        let BMR;

        if (gender === "male") {
            BMR = 10 * wei + 6.25 * height - 5 * age + 5;
        } else {
            BMR = 10 * wei + 6.25 * height - 5 * age - 161;
        }

        let TDEE = BMR * activityLevel;

        $("#BMR-val").text(BMR.toFixed(1));
        $("#TDEE-val").text(TDEE.toFixed(1));

        weekCalRate(TDEE);

        let PA = BMR * (activityLevel - 1);
        let TEF = 0.1 * (BMR + PA);

        let ctx = document.getElementById("TDEE-chart").getContext("2d");
/*TDEEチャーチャート*/
        if (tdeechart) tdeechart.destroy();

        tdeechart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["BMR", "PA", "TEF"],
                datasets: [{
                    data: [BMR, PA, TEF],
                    backgroundColor: [
                        "rgba(52, 60, 209, 0.7)",
                        "rgba(85, 255, 59, 0.7)",
                        "rgba(208, 208, 208, 0.7)"
                    ],
                    borderColor: "#fff",
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "right",
                        labels: {
                            font: {
                                size: 10 
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: "Breakdown of TDEE",
                        font: {
                            size: 14 
                        }
                    }
                }
            }
        });

    });



$(".clear").on("click", function (e) {
    e.preventDefault();
    $("#age").val("");
    $("#height").val("");
    $("#wei").val("");
    $("#gender").prop("selectedIndex", 0);
    $("#activity-level").prop("selectedIndex", 0);
    $("#BMR-val").text("/");
    $("#TDEE-val").text("/");
    if (tdeechart) {
        tdeechart.destroy();
        tdeechart = null;
    }
});



$(function() {
    $("#pfc-button").click(function() {

        let protein = parseFloat($("#protein-val").val()) || 0;
        let fat     = parseFloat($("#fat-val").val()) || 0;
        let carb    = parseFloat($("#carb-val").val()) || 0;

        let pCal = protein * 4;
        let fCal = fat * 9;
        let cCal = carb * 4;

        let total = pCal + fCal + cCal;

        if (total === 0) {
            $("#pfc-ratio").text("0:0:0");
            return;
        }

        let pRatio = Math.round((pCal / total) * 100);
        let fRatio = Math.round((fCal / total) * 100);
        let cRatio = Math.round((cCal / total) * 100);

        $("#pfc-ratio").text(`${pRatio}:${fRatio}:${cRatio}`);
    });
});


});

