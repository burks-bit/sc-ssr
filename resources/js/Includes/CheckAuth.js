// js/Includes/CheckAuth.js

export const getEndpointForRole = (userRole) => {
    if (userRole === 'admin') {
        return '/admin/members/save';
    } else {
        return '/moderator/members/save';
    } 
};
