# Original Repo:
https://bitbucket.org/vmcms/leadscore.wrapper

# LeadScore App API PHP wrapper

Supports the entire API for LeadScore App.

```
<?php

require 'vendor/autoload.php';

$LeadScore = new LeadScore\LeadScore(API_KEY);

$stages = $LeadScore->stages->view();
```

## Installing via Composer
The recommended way to install the LeadScore APP API wrapper is though [Composer](https://getcomposer.org/).

```
<?php

{
    "require": {
        "kennetn/leadscore": "^4.0"
    }
}
```

## Documentation

### Stage

*Use this function to access a list of all stages on the site.*


Get all stages for site, ordered by sorting key.

```
<?php

$stages = $LeadScore->stages->view();
```

### Owner

*Use this function to access a list of all owners on the site.*


Get all owners for site.

```
<?php

$owners = $LeadScore->owners->view();
```

### Segments

*Use this function to access a list of all segments on the site.*


Get all segments for site.

```
<?php

$segments = $LeadScore->segments->view();
```

### Lead

*Use these functions to get a list of all lead- and custom fields, add leads with creation of tracking cookie and apply tracking codes to links of HTML content.*


Get all lead- and customfields for site, customfields are ordered by sorting key.

```
<?php

$fields = $LeadScore->lead->fields();
```


Add lead with key-value paired fields, stage ID, owner ID, segment ID and whether or not to sync with 3rd party services, lead key is returned and saved in a cookie.

```
<?php

/**
 * $fields = [
 *     'email'              => 'name@example.com', // Email address
 *     'full_name'          => 'John Doe',         // Full name (Converts the name into first and last name)
 *     'first_name'         => 'John',             // First name
 *     'last_name'          => 'Doe',              // Last name
 *     'gender'             => 'MALE',             // Gender ('FEMALE', 'MALE' OR 'UNKNOWN')
 *     'title'              => 'Customer',         // Title
 *     'company'            => 'LeadScore App',    // Company
 *     'address'            => 'Bredgade 1',       // Address
 *     'zip'                => '7400',             // Zip code
 *     'city'               => 'Herning',          // City
 *     'country'            => 'Denmark',          // Country
 *     'phone'              => '12345678',         // Phone
 *     'phone_country_code' => '45',               // Phone country code
 *     'description'        => 'Lorem ipsum',      // Description
 *     '42'                 => '1.000,- DKK'       // Customfield "Budget" with customfield ID '42'
 * ];
 */
$response = $LeadScore->lead->add($fields, $stage_id = null, $owner_id = null, $segment_id = null, $sync = null);

setcookie('__lsk', $response['lead_key'], strtotime('+1 year'), '/'); // Save for one year
```


Change stage for one or more leads.

```
<?php

/**
 * $leads = [											// One or more leads with either ID, key or email
 *     [
 *         'id' => 42                                   // Lead ID
 *     ],
 *     [
 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
 *     ],
 *     [
 *         'email' => 'name@example.com'                // Lead email address
 *     ]
 * ];
 *
 * $stage_id = 42;
 */
 $result = $LeadScore->lead->stage($leads, $stage_id); // ['leads' => 3, 'edited' => 3, 'same' => 0]
```


Add segment to one or more leads.

```
<?php

/**
 * $leads = [											// One or more leads with either ID, key or email
 *     [
 *         'id' => 42                                   // Lead ID
 *     ],
 *     [
 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
 *     ],
 *     [
 *         'email' => 'name@example.com'                // Lead email address
 *     ]
 * ];
 *
 * $segment_id = 42;
 */
 $result = $LeadScore->lead->addToSegment($leads, $segment_id); // ['leads' => 3, 'changed' => 3, 'same' => 0]
```


Remove segment from one or more leads.

```
<?php

/**
 * $leads = [											// One or more leads with either ID, key or email
 *     [
 *         'id' => 42                                   // Lead ID
 *     ],
 *     [
 *         'key' => '8001083940a98db179c0473d9bc75ccf'  // Lead key
 *     ],
 *     [
 *         'email' => 'name@example.com'                // Lead email address
 *     ]
 * ];
 *
 * $segment_id = 42;
 */
 $result = $LeadScore->lead->removeFromSegment($leads, $segment_id); // ['leads' => 3, 'changed' => 3, 'same' => 0]
```


Apply tracking codes to a tag hrefs in a HTML string.

```
<?php

/**
 * $html                    = '<a href="leadscoreapp.dk">Klik her</a>';
 * $domains                 = ['leadscoreapp.dk'];
 * $key                     = '8001083940a98db179c0473d9bc75ccf';
 * $googleAnalyticsCampaign = 'leadscore';
 */
$html = $LeadScore->lead->applyTrackingCodes($html, $domains, $key, $googleAnalyticsCampaign);
```

### Deals

*Use these functions to add deal products and add deals to leads.*


Add product deal, will skip creation if slug is already existing, returns ID of deal product.

```
<?php

/**
 * $name     = 'Lorem ipsum';
 * $slug     = 'lorem-ipsum';
 * $dealMax  = 42;
 * $statusId = 42;
 */
$result = $LeadScore->deals->addProduct($name, $slug, $dealMax = null, $statusId = null);
```


Add deal for one or more deal products for one or more leads.

```
<?php

/**
 * $leads          = [                                    // One or more leads with either ID, key or email
 *     [
 *         'id'    => 42,                                 // Lead ID
 *     ],
 *     [
 *         'key'   => '8001083940a98db179c0473d9bc75ccf', // Lead key
 *     ],
 *     [
 *         'email' => 'name@example.com',                 // Lead email address
 *     ]
 * ];
 * $userId         = 42;                                  // User ID
 * $dealProducts   = [                                    // One or more products with either ID or slug
 *     [
 *         'id'   => 42,                                  // Deal product ID
 *     ],
 *     [
 *         'slug' => 'lorem_ipsum',                       // Deal product ID
 *     ]
 * ];
 * $saleValue      = 1337;                                // Sale value
 * $name           = 'Lorem ipsum';                       // Deal name
 * $note           = 'Lorem ipsum dolor sit amet';        // Deal note
 * $internalNote   = 'Lorem ipsum dolor sit amet';        // Internal note
 * $statusId       = 42;                                  // Deal status ID
 * $fields         = [									  // One or more deal custom field values
 *     42 => 'Foo',										  // Lead deal field ID => Value
 *     43 => 'Bar'
 * ];
 */
$result = $LeadScore->deals->addToLead($leads, $userId, $dealProducts, $saleValue, $name, $note = null, $internalNote = null, $statusId = null, $fields = []);
```
