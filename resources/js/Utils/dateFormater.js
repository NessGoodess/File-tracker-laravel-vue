

export const formatDateTime = (date) => {
    return new Date(date).toLocaleString([], {
        hour: '2-digit',
        minute: '2-digit',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
};

export function formatDate(date) {
    if (!date) return 'Sin Actualizaciones';
    return new Date(date).toLocaleDateString([], {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

export function formatDateEs(date) {
    if (!date) return 'Sin Actualizaciones';
    return new Date(date).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
}

export function formatDateTimeEs(date) {
    return new Date(date).toLocaleString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
}

export function timeElapsed(date) {
    const now = new Date();
    const difference = now - new Date(date);
    const seconds = Math.floor(difference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(months / 12);

    const rtf = new Intl.RelativeTimeFormat('es', { numeric: 'auto' });

    if (years > 0 || months > 0) {
        return new Date(date).toLocaleDateString('es-ES', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
    if (days > 0) return rtf.format(-days, 'day');
    if (hours > 0) return rtf.format(-hours, 'hour');
    if (minutes > 0) return rtf.format(-minutes, 'minute');
    return rtf.format(-seconds, 'second');
}
