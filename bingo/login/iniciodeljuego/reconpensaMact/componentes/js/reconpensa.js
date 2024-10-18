const rewardContainer = document.querySelector('.reward-container');

        let isDown = false;
        let startX;
        let scrollLeft;

        rewardContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            rewardContainer.classList.add('active');
            startX = e.pageX - rewardContainer.offsetLeft;
            scrollLeft = rewardContainer.scrollLeft;
        });

        rewardContainer.addEventListener('mouseleave', () => {
            isDown = false;
            rewardContainer.classList.remove('active');
        });

        rewardContainer.addEventListener('mouseup', () => {
            isDown = false;
            rewardContainer.classList.remove('active');
        });

        rewardContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - rewardContainer.offsetLeft;
            const walk = (x - startX) * 3; // Velocidad del scroll
            rewardContainer.scrollLeft = scrollLeft - walk;
        });