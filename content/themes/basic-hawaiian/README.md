# Basic Hawaiian WordPress Theme

Welcome!

## Migration Notes

1. Update Git
2. Update Composer
3. Update Bower
4. Update NPM
5. Update ACF


## Database Considerations

#### Production to Dev
!!!! MAKE SURE TO UPDATE STRIPE SETTINGS !!!!!
cat wp_basichawaiian_prod.sql | sed -e 's/http:\/\/basichawaiian.com\/wp/http:\/\/192.168.20.30\/wp/g' | sed -e 's/http:\/\/localhost:8888\/BasicHawaiian/http:\/\/192.168.20.30\/wp/g' | sed -e 's/http:\/\/dev3.localhost\/wp/http:\/\/192.168.20.30\/wp/g' > wp_basichawaiian_dev.sql

### Creating a New Instance
1. Need a clean ACF setting template.


Getting Started
---------------

If you want to keep it simple, head over to http://underscores.me and generate your `_s` based theme from there. You just input the name of the theme you want to create, click the "Generate" button, and you get your ready-to-awesomize starter theme.

If you want to set things up manually, download `_s` from GitHub. The first thing you want to do is copy the `_s` directory and change the name to something else (like, say, `megatherium`), and then you'll need to do a five-step find and replace on the name in all the templates.

1. Search for `'_s'` (inside single quotations) to capture the text domain.
2. Search for `_s_` to capture all the function names.
3. Search for `Text Domain: _s` in style.css.
4. Search for <code>&nbsp;_s</code> (with a space before it) to capture DocBlocks.
5. Search for `_s-` to capture prefixed handles.

OR

* Search for: `'_s'` and replace with: `'megatherium'`
* Search for: `_s_` and replace with: `megatherium_`
* Search for: `Text Domain: _s` and replace with: `Text Domain: megatherium` in style.css.
* Search for: <code>&nbsp;_s</code> and replace with: <code>&nbsp;Megatherium</code>
* Search for: `_s-` and replace with: `megatherium-`

Then, update the stylesheet header in `style.css` and the links in `footer.php` with your own information. Next, update or delete this readme.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!
