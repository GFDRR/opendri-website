# WordPress

This is a WordPress repository configured to run on the [Pantheon platform](https://pantheon.io).

Pantheon is website platform optimized and configured to run high performance sites with an amazing developer workflow. There is built-in support for features such as Varnish, Redis, Apache Solr, New Relic, Nginx, PHP-FPM, MySQL, PhantomJS and more. 

## Getting Started

### 1. Spin-up a site

If you do not yet have a Pantheon account, you can create one for free. Once you've verified your email address, you will be able to add sites from your dashboard. Choose "WordPress" to use this distribution.

### 2. Load up the site

When the spin-up process is complete, you will be redirected to the site's dashboard. Click on the link under the site's name to access the Dev environment.

![alt](http://i.imgur.com/2wjCj9j.png?1, '')

### 3. Run the WordPress installer

How about the WordPress database config screen? No need to worry about database connection information as that is taken care of in the background. The only step that you need to complete is the site information and the installation process will be complete.

We will post more information about how this works but we recommend developers take a look at `wp-config.php` to get an understanding.

![alt](http://i.imgur.com/4EOcqYN.png, '')

If you would like to keep a separate set of configuration for local development, you can use a file called `wp-config-local.php`, which is already in our .gitignore file.

### 4. Enjoy!

![alt](http://i.imgur.com/fzIeQBP.png, '')

# Project charts shortcodes


#### Global parameters

Set in Settings > OSMA charts:

- __OSMA API -> API URL__ Endpoint used for all API calls
- __OSMA Site -> Site URL__ URL of the iframe for the compare maps module

#### Compare map

```
[osma_charts_compare_map country="HTI" default_feature_type="highways" default_start_year="2015" default_end_year="now"]
```

- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __default_start_year__ (`2016`) represents the start year of an OpenDRI project
- __default_end_year__ (`now`) represents the end year of an OpenDRI project. `now` can also be provided to compare with latest OSM data
- __default_feature_type__ (`buildings`) compare `buildings` or `highways`

#### OSM activity

```
[osma_charts_activity country="HTI" start_date="2000-01-01" end_date="2017-02-01" default_granularity="monthly" default_facet="features"]
```

- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
- __default_granularity__ (`daily`) show activity `daily|weekly|monthly` by default
- __default_facet__ (`features`) show either `features` or `users` histogram by default

#### OSM top contributors
```
[osma_charts_contributors country="HTI" start_date="2000-01-01" end_date="2017-02-01"]
```

- __country__ or __polygon__ (mandatory) ISO3 country code or an encoded polyline of the area of interest related to the project (ie `ifv%7BDndwkBx%60%40aYwQev%40sHkPuf%40ss%40%7BfA_%40uq%40xdCn%7D%40%5E`))
- __start_date__ (mandatory) (`2016-01-01`) represents the start date of an OpenDRI project
- __end_date__ (mandatory) (`2017-01-01`) represents the end date of an OpenDRI project
