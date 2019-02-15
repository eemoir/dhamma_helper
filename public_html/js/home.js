var token = document.head.querySelector('meta[name="csrf-token"]').content
var meditationChart

document.addEventListener('DOMContentLoaded', () => {
    var modal = jQuery("#modal")
    if (modal) {
        modal.modal('show')
        if (document.getElementById('decline')) {
            document.getElementById('decline').addEventListener('click', () => {
                fetch('/incrementLogin', {
                    'method': 'POST', 
                    'headers': {
                        'X-CSRF-TOKEN': token,
                    }
                })
            })
        }   
    }
    
    if (!document.getElementById('no-stats')) {
        let now = new Date()
        let data = new FormData()
        data.append('offset', now.getTimezoneOffset())
        fetch('/loadChart', {
            'method': 'POST',
            'body': data,
            'headers': {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            return response.json()
        }).then(response => {
            let labels = []
            let data = []
            JSON.parse(response['chartData'])[0]['data'].forEach((item, index) => {
                if (index%2 === 0) {
                    labels.push(item)
                } else {
                    data.push(item)
                }
            })
            if (data.length > 0) {
                document.getElementById('chart-title').innerHTML = 'Minutes Meditated per Day'
                let ctx = document.getElementById('chart-div')
                let colors = Array(data.length).fill('rgba(217, 139, 224, 0.2)')
                let borderColors = Array(data.length).fill('rgba(217, 139, 224, 1)')
                meditationChart = new Chart(ctx, {
                    type: 'bar', 
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Minutes Meditated",
                            data: data,
                            backgroundColor: colors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }],
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    suggestedMin: 0,
                                    suggestedMax: response['max']
                                }
                            }]
                        },
                    }
                })
            }
            let select = document.createElement('select')
            let option = document.createElement('option')
            let weekBeginning = new Date(response['weekBeginning']['date'])
            option.value = weekBeginning.toUTCString()
            option.innerHTML = returnWeekRange(weekBeginning)
            select.appendChild(option)
            let selectDiv = document.getElementById('select-div')
            selectDiv.appendChild(select)
            let earliest = new Date(response['earliest']['date'])
            while (earliest <= addDays(subtractDays(weekBeginning, 7), 6)) {
                weekBeginning.setDate(weekBeginning.getDate() - 7)
                let option = document.createElement('option')
                option.value = weekBeginning.toUTCString()
                option.innerHTML = returnWeekRange(weekBeginning)
                select.appendChild(option)
            }
            select.addEventListener('change', function(e) {
                let dateString = e.target.value
                let date = new Date(dateString)
                let year = date.getFullYear()
                let day = date.getDate()
                let month = date.getMonth()
                let now = new Date()
                let data = new FormData()
                data.append('offset', now.getTimezoneOffset())
                data.append('year', year)
                data.append('day', day)
                data.append('month', month)
                fetch('/reloadChart', {
                    'method': 'POST',
                    'body': data,
                    'headers': {
                        'X-CSRF-TOKEN': token,
                    }
                }).then(response => {
                    return response.json()
                }).then(response => {
                    labels = []
                    data = []
                    JSON.parse(response['chartData'])[0]['data'].forEach((item, index) => {
                        if (index%2 === 0) {
                            labels.push(item)
                        } else {
                            data.push(item)
                        }
                    })
                    if (data.length > 0) {
                        meditationChart.data.labels = labels
                        meditationChart.data.datasets[0].data = data
                        meditationChart.update()
                    }
                    
                })
            })
            document.getElementById('loader').className = "invisible"
            fadeIn(document.getElementById('stats'), 1000)
            document.getElementById('stats').className = ""
        })
        fetch('/averageMeditationLength', {
            'method': 'POST',
            'headers': {
                'X-CSRF-TOKEN': token,
            }
       }).then(response => {
            return response.json()
        }).then(response => {
            let span = document.getElementById('average')
            let average = response['average']
            span.innerHTML = parseFloat(average).toFixed(2)
        })
        let fetchData = new FormData()
        now = new Date()
        fetchData.append('offset', now.getTimezoneOffset())
        fetch('/averageMinutesPerDay', {
            'method': 'POST',
            'body': fetchData,
            'headers': {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            return response.json()
        }).then(response => {
            document.getElementById('average-day').innerHTML = parseFloat(response['average']).toFixed(2)
        })
        fetch('/longestRun', {
            'method': 'POST',
            'body': fetchData,
            'headers': {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            return response.json()
        }).then(response => {
            document.getElementById('longest-run').innerHTML = response['longest']
        })
        fetch('/currentRun', {
            'method': 'POST',
            'body': fetchData,
            'headers': {
                'X-CSRF-TOKEN': token,
            }
        }).then(response => {
            return response.json()
        }).then(response => {
            document.getElementById('current-run').innerHTML = response['current']
        })
    }
})

function returnWeekRange(date) {
    let firstDate = returnDateString(date)
    let lastDate = returnDateString(addDays(date, 6))
    let rangeString = `${firstDate}-${lastDate}`
    return rangeString
}

function returnDateString(date) {
    let dateString
    let month = date.getMonth() + 1
    if (month < 10) {
        month = `0${month}`
    } else {
        month = month.toString()
    }
    let day = date.getDate()
    if (day < 10) {
        day = `0${day}`
    } else {
        day = day.toString()
    }
    let currentYear = new Date().getFullYear()
    if (date.getFullYear() == currentYear) {
        dateString = `${month}/${day}`
    } else {
        let year = date.getFullYear().toString().slice(2)
        dateString = `${month}/${day}/${year}`
    }
    return dateString
}

function addDays(date, days) {
    let result = new Date(date)
    result.setDate(result.getDate() + days)
    return result
}

function subtractDays(date, days) {
    let result = new Date(date)
    result.setDate(result.getDate() - days)
    return result
}

function fadeIn(el, time) {
  el.style.opacity = 0;

  var last = new Date();
  var tick = function() {
    el.style.opacity = +el.style.opacity + (new Date() - last) / time;
    last = +new Date();

    if (+el.style.opacity < 1) {
      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
    }
  };

  tick();
}