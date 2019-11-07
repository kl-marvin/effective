let date = new Date();
let time = date.getHours();

let message1 = document.getElementsByClassName('greeting')[0];
let message2 = document.getElementsByClassName('greeting')[1];

changeGreeting = () => {
        if(time < 12){
            message1.innerHTML = 'Good Morning,'
            message2.innerHTML = 'Good Morning,'
        }else if(time >= 12){
            message1.innerHTML = 'Good Afternoon,'
            message2.innerHTML = 'Good Afternoon,'
        }
}

changeGreeting();



function startTime() {
    let today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    m = checkTime(m);
    document.getElementById('hour').innerHTML = h + ":" + m ;
    document.getElementById('hour2').innerHTML = h + ":" + m ;
    let t = setTimeout(startTime, 500);
  }
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }


startTime();

console.log(time);


