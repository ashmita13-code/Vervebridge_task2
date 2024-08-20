document.addEventListener('DOMContentLoaded', () => {
    const paragraphs = document.querySelectorAll('.fly-in');
    
    paragraphs.forEach((para, index) => {
        // Determine the animation direction based on the index
        if (index % 2 === 0) {
            para.classList.add('from-right');
        } else {
            para.classList.add('from-left');
        }

        // Apply the visible class with a delay
        setTimeout(() => {
            para.classList.add('visible');
        }, index * 1000); // Adjust delay as needed
    });
});
