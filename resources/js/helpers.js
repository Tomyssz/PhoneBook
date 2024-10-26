document.addEventListener("DOMContentLoaded", function () {
    initTomSelect();
});

const initTomSelect = () => {
    new TomSelect(".tom-select.multiple", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true
    });

    const originalObjects = document.querySelectorAll('.tom-select.multiple');

    originalObjects?.forEach(obj => {
        obj.parentNode.querySelector('.ts-wrapper .ts-control').classList.add('rounded-md')
    })
}

