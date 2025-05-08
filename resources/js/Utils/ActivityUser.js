export const actionUser = (activity) => {
    if (activity === 'store') {
        return 'Alta';
    } else if (activity === 'update') {
        return 'Modificacion';
    } else if (activity === 'delete') {
        return 'Eliminacion';
    }
};
