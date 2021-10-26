<?php

return [
    'page_title_admin/dashboard' => 'Tableau de bord',
    'page_title_register' => 'S\'inscrire',
    'register' => 'Enregistrement',
    'register_name' => 'Nom du responsable',
    'register_company_name' => 'Nom de la compagnie',
    'register_email' => 'Adresse courriel',
    'register_password' => 'Mot de passe',
    'register_password_confirm' => 'Confirmer mot de passe',
    'register_button' => 'S\'inscrire',
    'register_button_form' => 'Enregistrer',
    'email' => 'Adresse courriel',
    'page_title_login' => 'Connexion',
    'go_back' => 'Retour',
    'login_button' => 'Se connecter',
    'password' => 'Mot de passe',
    'remember_me' => 'Se souvenir de moi',
    'forgot_password' => 'Oublié votre mot de passe?',
    'navigation_logout_button' => 'Se déconnecter',
    'generic_send_button' => 'Envoyer',
    'generic_cancel_button' => 'Annuler',
    'welcome_message' => 'Bonjour :user! Bienvenue chez Savons My!',
    'page_title_dashboard' => 'Bienvenue!',
    'page_title_purchase-orders' => 'Bons de commandes',
    'page_title_purchase-orders/add' => 'Envoyer un bon de commande (Dernière mise à jour: :currentVersionDate)',
    'page_title_purchase-orders/{orderId}' => 'Visualisation de la commande # :orderId envoyée le :createdAt',
    'page_title_purchase-orders/{orderId}/update' => 'Modifier le bon de commande # :orderId',

    'navigation_dashboard_title' => 'Tableau de bord',
    'navigation_purchase_order_title' => 'Bons de commandes',
    'purchase_order_lead' => 'Vos commandes',
    'page_title_admin/orders/{orderId}' => 'Commande # :orderId',
    'page_title_admin/orders/{orderId}/status' => 'Changer le status de la commande # :orderId',
    'page_title_admin/poform' => 'Mise a jour du formulaire (v:currentVersion => v:nextVersion)',
    'page_title_admin/user/{userId}/assign_client' => 'Assigner un utilisateur à un client',
    'page_title_admin/clients' => 'Clients',
    'page_title_admin/clients/new' => 'Ajout d\'un nouveau client',
    'page_title_admin/clients/{clientId}' => "Mise à jour du client # :clientId",

    'purchase_order_add_new_button' => 'Créer un bon de commande',

    // Variables
    'validation_error_title' => 'Oops! Une erreur est survenue!',
    'order_status_' . \App\Constants\OrderStatus::NOT_TREATED => 'Non traité',
    'order_status_' . \App\Constants\OrderStatus::IN_PROGRESS => 'En traitement',
    'order_status_' . \App\Constants\OrderStatus::COMPLETED => 'Complété',
    'order_status_' . \App\Constants\OrderStatus::CANCELLED => 'Annulée',

    'register_validation_name_required' => 'Le nom du responsable est requis',
    'register_validation_company_name_required' => 'Le nom de la compagnie est requis',
    'register_validation_email_required' => 'L\'adresse courriel est requise',
    'register_validation_email_email' => 'L\'adresse courriel doit être du format user@domain.ext',
    'register_validation_email_unique' => 'L\'adresse courriel existe déjà dans le système',
    'register_validation_pwd_required' => 'Le mot de passe est requis',
    'register_validation_pwd_min' => 'Le mot de passe doit contenir un minimum de 8 caractères',
    'register_validation_pwd_confirm' => 'Le mot de passe de confirmation doit être le même que le mot de passe',
];
