# TMK Community

A small PHP-served, Netflix-inspired watch-party UI prototype with a clean modern cold-blue-on-charcoal theme. It has a demo signup/login flow, arithmetic human check, movie search, room-size selection, local video controls, an in-browser chat mockup, and an external beIN SPORTS link.

## Run locally

From this folder, start PHP's built-in development server:

```sh
php -S localhost:8000
```

Then open http://localhost:8000.

## Prototype notes

- The movie catalog is loaded from `data/catalog.json` by `index.php`.
- Login/account state and demo chat are local to the current browser; the demo password is stored in localStorage. Do not use a real password.
- No production authentication, server-side account store, real-time chat, invitations, synced playback, or video hosting is implemented.
- Movie cards use remote Unsplash imagery. The player uses Google's public Big Buck Bunny sample video as a non-commercial demo clip; replace it with media you have the rights to serve.
- Sports opens the official beIN SPORTS website in a new tab; this app does not stream sports.
