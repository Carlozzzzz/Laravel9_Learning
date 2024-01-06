class Timey {
    constructor(hh, mm, ss) {
        this.hours = hh;
        this.minutes = mm;
        this.seconds = ss;
    }

    startTimey(callback) {
        let quizStartAt = this.addTimeToCurrent();
        let countDownDate = quizStartAt;

        let x = setInterval(() => {
            const now = new Date().getTime();
            let distance = countDownDate - now;

            let hours = Math.floor(distance / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let timerData = {
                hours : hours,
                minutes : minutes,
                seconds : seconds
            }

            if (distance < 0) {
                clearInterval(x);

                const keys = Object.keys(timerData);
                keys.forEach((key) => {
                    timerData[key] = 0;
                });
            }

            callback(timerData);
        }, 1000);
    }

    addTimeToCurrent() {
        const currentDate = new Date();
        currentDate.setHours(currentDate.getHours() + this.hours);
        currentDate.setMinutes(currentDate.getMinutes() + this.minutes);
        currentDate.setSeconds(currentDate.getSeconds() + this.seconds);
        return currentDate.getTime();
    }
}
