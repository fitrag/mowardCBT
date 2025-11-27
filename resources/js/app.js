import './bootstrap';
import Swal from 'sweetalert2';

window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#ffffff',
    color: '#0f172a', // Slate 900
    iconColor: '#4f46e5', // Indigo 600
    customClass: {
        popup: 'rounded-xl shadow-lg border border-slate-200 ring-1 ring-black/5 font-sans',
        title: 'text-sm font-semibold text-slate-900',
        timerProgressBar: 'bg-indigo-500'
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;

document.addEventListener('livewire:navigated', () => {
    // Listen for toast events from Livewire
    Livewire.on('toast', (data) => {
        // data is an array, take the first item
        const payload = data[0];
        Toast.fire({
            icon: payload.type,
            title: payload.message
        });
    });
});

// Handle confirmation dialogs via Alpine/Livewire
window.confirmAction = (title, text, confirmButtonText, callback) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel',
        background: '#ffffff',
        color: '#0f172a',
        buttonsStyling: false, // Disable default SweetAlert2 styles
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-slate-100 font-sans p-6',
            title: 'text-xl font-bold text-slate-900 mb-2',
            htmlContainer: 'text-slate-500 text-sm',
            confirmButton: 'bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl px-5 py-2.5 shadow-sm transition-all mx-2',
            cancelButton: 'bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-xl px-5 py-2.5 shadow-sm ring-1 ring-inset ring-slate-300 transition-all mx-2',
            actions: 'mt-6 flex justify-center gap-x-3',
            icon: '!border-amber-400 !text-amber-400'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};
