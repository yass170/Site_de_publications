document.addEventListener('DOMContentLoaded', () => {
    // Example: Close notification
    (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
        var $notification = $delete.parentNode;

        $delete.addEventListener('click', () => {
            $notification.parentNode.removeChild($notification);
        });
    });

    
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            alert("Formulaire envoyé avec succès !");
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const logoutLink = document.getElementById('logout');

    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche l'action par défaut de se produire (redirection)

            const confirmation = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
            
            if (confirmation) {
                // Redirige vers la page de déconnexion si l'utilisateur confirme
                window.location.href = "logout.php";
            }
        });
    }
});
