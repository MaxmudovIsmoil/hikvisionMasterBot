function loadData() {
    let ctx2 = document.getElementById('doughnut').getContext('2d');
    let url = document.getElementById('doughnut').getAttribute('data-url');
    fetch(url).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(response => {
            // Do something with the JSON data
            if (response.success) {
                // let length = response.data.map(group => group.name).length;
                let groups = response.data.map(group => group.name);
                let groupUsersCount = response.data.map(group => group.user_count);

                let backgroundColor = [];
                let borderColor = [];
                for (let i = 0; i < groups.length; i++) {
                    let color = `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`;
                    backgroundColor.push(color);
                    borderColor.push(color);
                }
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: groups,
                        datasets: [{
                            label: 'Employees',
                            data: groupUsersCount,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

            }
            console.log('response:', response);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

loadData();

