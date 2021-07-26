<?php

return [
    'page_title_admin/dashboard' => 'Tableau de bord',
    'email' => 'Adresse courriel',
    'page_title_login' => 'Connexion',
    'login_button' => 'Se connecter',
    'password' => 'Mot de passe',
    'remember_me' => 'Se souvenir de moi',
    'forgot_password' => 'Oublié votre mot de passe?',
    'register_button' => 'S\'inscrire',
    'navigation_logout_button' => 'Se déconnecter',
    'generic_send_button' => 'Envoyer',
    'generic_cancel_button' => 'Annuler',
    'welcome_message' => 'Bonjour :user! Bienvenue chez Savons My!',

    'navigation_purchase_order_title' => 'Bons de commandes',
    'page_title_admin/orders/{orderId}' => 'Commande # :orderId',

    'page_title_admin/poform' => 'Mise a jour du formulaire (v:currentVersion => v:nextVersion)',

    'purchase_order_add_new_button' => 'Créer un bon de commande',
    'purchase_order_add_main_title' => 'Envoyer un bon de commande',
    'purchase_order_update_main_title' => 'Modifier le bon de commande # :orderId',

    // Variables
    'validation_error_title' => 'Oops! Une erreur est survenue!',
    'order_status_' . \App\Constants\OrderStatus::NOT_TREATED => 'Non traité',
    'order_status_' . \App\Constants\OrderStatus::IN_PROGRESS => 'En traitement',
    'order_status_' . \App\Constants\OrderStatus::COMPLETED => 'Complété',
];
