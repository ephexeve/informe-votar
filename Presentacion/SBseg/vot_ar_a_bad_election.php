<?php
/*
  Vot.Ar: a bad election. Presentation for the SBSeg #15, nov 2015
  by HacKan | Ivan A. Barrera Oro | https://hackancuba.github.io
  Licence CC BY-SA v4.0: http://creativecommons.org/licenses/by-sa/4.0/
  Feel free to share!!
*/

error_reporting(E_ALL);

/**
 * Defines if Overview will be shown if no parameter is passed through GET
 */
define('SHOW_OVERVIEW', false);

class Position
{
  /**
   * Coordinates (data-...)
   */
  private $_x, $_y, $_z;
  /**
   * Angles (data-rotate-...)
   */
  private $_alpha, $_theta, $_phi;
  /**
   * Overview position (could be automated)
   */
  private $_overviewX, $_overviewY, $_overviewS;

  function __construct()
  {
    $this->reset();
  }

  /**
   * Sets the Overview coordinates. Values can be negative.
   *
   * @param array $coord
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "s" => 3] or [1, 2, 3]
   * Note that S is the Scale.
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   *
   */
  public function set_overview($overview)
  {
    if (is_array($overview)) {
      $this->_overviewX = array_key_exists("x", $overview)
                                          ? $overview["x"]
                                          : (array_key_exists(0, $overview)
                                                            ? $overview[0]
                                                            : $this->_overviewX
                                            );
      $this->_overviewY = array_key_exists("y", $overview)
                                          ? $overview["y"]
                                          : (array_key_exists(1, $overview)
                                                            ? $overview[1]
                                                            : $this->_overviewY
                                            );
      $this->_overviewS = array_key_exists("s", $overview)
                                          ? $overview["s"]
                                          : (array_key_exists(2, $overview)
                                                            ? $overview[2]
                                                            : $this->_overviewS
                                            );
    }
  }

  /**
   * This method calculates the overview coordinates based on the
   * currently set coords, asuming these are the final ones, and that
   * the first ones are [0,0]
   */
  public function autoset_overview()
  {
    $this->_overviewX =  (int) ($this->_x / 2);
    $this->_overviewY =  (int) ($this->_y / 2);
    // how can I calculate this? I think it can be done w/ the
    // screen resolution
    //$this->_overviewS = 32
  }

  /**
   * Sets the coordinates to a given value. Values can be negative.
   *
   * @param array|numeric $coord [optional]
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only X.
   */
  public function set_coord($coord)
  {
    if (is_array($coord)) {
      $this->_x = array_key_exists("x", $coord)
                                  ? $coord["x"]
                                  : (array_key_exists(0, $coord)
                                                    ? $coord[0]
                                                    : $this->_x
                                    );
      $this->_y = array_key_exists("y", $coord)
                                  ? $coord["y"]
                                  : (array_key_exists(1, $coord)
                                                    ? $coord[1]
                                                    : $this->_y
                                    );
      $this->_z = array_key_exists("z", $coord)
                                  ? $coord["z"]
                                  : (array_key_exists(2, $coord)
                                                    ? $coord[2]
                                                    : $this->_z
                                    );
    } elseif (is_numeric($coord)) {
      $this->_x = $coord;
    }
  }

  /**
   * Sets the angles to a given value. Values can be negative.
   *
   * @param array|numeric $angle [optional]
   * an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "phi" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function set_angle($angle)
  {
    if (is_array($angle)) {
      $this->_alpha = array_key_exists("alpha", $angle)
                                      ? $angle["alpha"]
                                      : (array_key_exists(0, $angle)
                                                        ? $angle[0]
                                                        : $this->_alpha
                                        );
      $this->_theta = array_key_exists("theta", $angle)
                                      ? $angle["theta"]
                                      : (array_key_exists(1, $angle)
                                                        ? $angle[1]
                                                        : $this->_theta
                                        );
      $this->_phi = array_key_exists("phi", $angle)
                                      ? $angle["phi"]
                                      : (array_key_exists(2, $angle)
                                                        ? $angle[2]
                                                        : $this->_phi
                                        );
    } elseif (is_numeric($angle)) {
      $this->_alpha = $angle;
    }
  }

  /**
   * Sets the coordinates and angles to a given value. Values can
   * be negative.
   *
   * @param array|numeric $coord [optional]
   * an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for only X.
   *
   * @param array|numeric $angle [optional]
   * an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "phi" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * Elements not set will be omitted, keeping it's current value!.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function set($coord = NULL, $angle = NULL)
  {
    $this->set_coord($coord);
    $this->set_angle($angle);
  }

  /**
   * Sets coords to 0.
   */
  public function reset_coord()
  {
    $this->set_coord([0, 0, 0]);
  }

  /**
   * Sets angles to 0.
   */
  public function reset_angle()
  {
    $this->set_angle([0, 0, 0]);
  }

  /**
   * Sets overview to [0, 0, 0].
   */
  private function reset_overview()
  {
    $this->set_overview([0, 0, 0]);
  }

  /**
   * Sets coords and angles to 0.
   */
  public function reset()
  {
    $this->reset_coord();
    $this->reset_angle();
    $this->reset_overview();
  }


  /**
   * Get the coordinates
   *
   * @return array An array of coordinates
   */
  public function get_coord()
  {
    return [$this->_x, $this->_y, $this->_z];
  }

  /**
   * Get the angles
   *
   * @return array An array of angles
   */
  public function get_angle()
  {
    return [$this->_alpha, $this->_theta, $this->_phi];
  }

  /**
   * Shifts the coordinates with a given value.  This means that it adds
   * the value to current coords.  Values can be negative.
   *
   * @param array|numeric $delta an array of coordinates such as
   * [ "x" => 1, "y" => 2, "z" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * It can also be a numeric, and if so, it will be considered for
   * only X.
   */
  public function shift_coord($delta)
  {
    if (is_array($delta)) {
      $this->_x += array_key_exists("x", $delta)
                                  ? $delta["x"]
                                  : (array_key_exists(0, $delta)
                                                    ? $delta[0]
                                                    : 0
                                    );
      $this->_y += array_key_exists("y", $delta)
                                  ? $delta["y"]
                                  : (array_key_exists(1, $delta)
                                                    ? $delta[1]
                                                    : 0
                                    );
      $this->_z += array_key_exists("z", $delta)
                                  ? $delta["z"]
                                  : (array_key_exists(2, $delta)
                                                    ? $delta[2]
                                                    : 0
                                    );
    } elseif (is_numeric($delta)) {
      $this->_x += $delta;
    }
  }

  /**
   * Shifts the angles with a given value.  This means that it adds
   * the value to current angles.  Values can be negative.
   *
   * @param array|numeric $delta an array of angles such as
   * [ "alpha" => 1, "theta" => 2, "" => 3] or [1, 2, 3]
   * It's not necessary to set all three elements.
   * It can also be a numeric, and if so, it will be considered for
   * only alpha.
   */
  public function shift_angle($delta)
  {
    if (is_array($delta)) {
      $this->_alpha += array_key_exists("alpha", $delta)
                                      ? $delta["alpha"]
                                      : (array_key_exists(0, $delta)
                                                        ? $delta[0]
                                                        : 0
                                        );
      $this->_theta += array_key_exists("theta", $delta)
                                      ? $delta["theta"]
                                      : (array_key_exists(1, $delta)
                                                        ? $delta[1]
                                                        : 0
                                        );
      $this->_phi += array_key_exists("phi", $delta)
                                      ? $delta["phi"]
                                      : (array_key_exists(2, $delta)
                                                        ? $delta[2]
                                                        : 0
                                        );
    } elseif (is_numeric($delta)) {
      $this->_alpha += $delta;
    }
  }

  /**
   * Shifts the coords and/or angles.
   * Equal as calling shift_coord() and shift_angle().
   *
   * @param array|numeric $delta_coord [optional]
   * @param array|numeric $delta_angle [optional]
   */
  public function shift($delta_coord = NULL, $delta_angle = NULL)
  {
    $this->shift_coord($delta_coord);
    $this->shift_angle($delta_angle);
  }

  /**
   * Prints the required text to set the coordinates and angles
   * for impress.js
   */
  public function printc()
  {
    echo 'data-x="' . $this->_x
            . '" data-y="' . $this->_y
            . '" data-z="' . $this->_z . '"';

    echo ' ';

    echo 'data-rotate-x="' . $this->_alpha
            . '" data-rotate-y="' . $this->_theta
            . '" data-rotate-z="' . $this->_phi . '"';
  }

  /**
   * Combination of calling: shift() and printc().
   *
   * @param array|numeric $delta_coord [optional]
   * @param array|numeric $delta_angle [optional]
   */
  public function shiftprint($delta_coord = NULL, $delta_angle = NULL)
  {
    $this->shift($delta_coord, $delta_angle);
    $this->printc();
  }

  public function print_overview()
  {
    echo '<div id="overview" class="step" '
            . 'data-x="' . $this->_overviewX . '" '
            . 'data-y="' . $this->_overviewY . '" '
            . 'data-scale="' . $this->_overviewS . '"'
            . '></div>';
  }
}

function get_opt($opt)
{
  return (array_key_exists($opt, $_GET)
                          ? $_GET[$opt]
                          : ''
          );
}

$show_overview = (get_opt('overview') != '')
                  ? true
                  : SHOW_OVERVIEW;

$pos = new Position;
$pos->set_overview(["s" => 65]);
?>
<!DOCTYPE html>
<html lang="en">
<!--
  Vot.Ar: una mala eleccion. Presentation for the SBSeg #15, nov 2015
  by HacKan | Ivan A. Barrera Oro | https://hackancuba.github.io
  Licence CC BY-SA v4.0: http://creativecommons.org/licenses/by-sa/4.0/
  Feel free to share!!

  v20151101

  Note: vulnerability level by DREAD:
                                  {D, R, E, A, D} = [0, 10]
  Given any vuln/threat t:
                                  t ∈ {low,med,high,crit} ⊂ R
                                  ∧ 10>crit>high>med>low>0
                                  ∧ 0 < low < 2.5
                                  ∧ med < 5
                                  ∧ high < 7.5
                                  ∧ crit < 10
  => t=(D+R+E+A+D)/5
-->
<head>
  <meta charset="utf-8">

  <title>Vot.Ar: a bad election</title>
  <meta name="author" content="Iv&aacute;n A. Barrera Oro"/>
  <meta name="description" content="Vot.Ar: a bad election. Presentation for the SBSeg #15, nov 2015"/>
  <link rel="icon" href="img/logo.png" sizes="196x196" type="image/png"/>

  <link href="css/reset.css" rel="stylesheet"/>
  <link href="css/presentation.css" rel="stylesheet"/>
  <link href="font/opensans.css" rel="stylesheet"/>
  <link href="font/oswald.css" rel="stylesheet"/>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>

  <meta name="twitter:card" content="summary"/>
  <meta name="twitter:site" content="@hackancuba"/>
  <meta name="twitter:image" content="img/logo.png"/>
  <meta name="twitter:title" content="Vot.Ar: a bad election"/>
  <meta name="twitter:description" content="Presentation for #sbseg15, nov 2015"/>

  <meta property="og:title" content="Vot.Ar: a bad election"/>
  <meta property="og:description" content="Presentation for #sbseg15, nov 2015"/>
  <meta property="og:locale" content="en_GB"/>
</head>

<body class="impress-not-supported">

	<div class="fallback-message">
		<p>Your browser <em>doesn't support the characteristics required</em> for this presentation, so a simplified version will be shown.</p>
		<p>For a better experience, please use <strong>Firefox</strong>, <strong>Chrome</strong> or <strong>Safari</strong>.</p>
	</div>

	<div id="impress">
    <!-- welcome -->
    <div id="title" class="step anim" <?php $pos->printc(); ?> data-scale="3">
      <h1 class="centered">Vot.Ar: a bad election</h1>
      <div class="sbseg-intro">
        <div class="content">
          <h3>A presentation about the <i class="scaling flag-blue">Vot.Ar</i> (aka BUE) system, its HW, SW &amp; Vulns.</h3>
          <p>Also, a bit about <i>eVoting</i>.</p>
          <p>For the <a class="link" href="http://sbseg2015.univali.br/">SBSeg 15</a>, Florianopolis, Brasil.</p>
        </div>
      </div>
      <p class="footnote"><a class="link-shadow" href="https://twitter.com/hashtag/VotArUnaMalaEleccion" target="_blank">#VotArUnaMalaEleccion</a> <a class="link-shadow" href="https://twitter.com/hashtag/sbseg15" target="_blank">#sbseg15</a></p>
		</div>
    <!-- -->

    <!-- authors -->
    <div id="authors" class="step" <?php $pos->shift(["y" => 4000], -30); $pos->printc(); ?> data-scale="10">
      <p>Presenter: <a class="link" target="_blank" href="https://twitter.com/hackancuba">Iv&aacute;n (HacKan) A. Barrera Oro</a>.</p>
      <p>Colaborators:
        <a class="link" target="_blank" href="https://twitter.com/famato">Francisco Amato</a>,
        <a class="link" target="_blank" href="https://twitter.com/FViaLibre">Enrique Chaparro</a>,
        <a class="link" target="_blank" href="https://twitter.com/SDLerner">Sergio Demian Lerner</a>,
        <a class="link" target="_blank" href="https://twitter.com/ortegaalfredo">Alfredo Ortega</a>,
        <a class="link" target="_blank" href="https://twitter.com/julianor">Juliano Rizzo</a>,
        <a class="link" target="_blank" href="https://www.onapsis.com/blog/author/fernando-russ">Fernando Russ</a>,
        <a class="link" target="_blank" href="https://twitter.com/mis2centavos">Javier Smaldone</a>,
        <a class="link" target="_blank" href="https://twitter.com/nicowaisman">Nicolas Waisman</a>.
      </p>
      <p class="footnote">And the people of the internet...</p>
    </div>
    <?php $pos->shift(8500); ?>
    <!-- - -->

    <!-- intro -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["z" => -300], -40); ?> data-scale="1">
      <h2>How did we do this?</h2>
      <ul>
        <li>About a week or so of hard work.</li>
        <li><strong>Unofficially</strong>: no assistance was provided by the company nor govt.</li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y"=>"730"]); ?> data-scale="1">
      <ul>
        <li>By going to public consultation points to have access to machines and ballots.</li>
      </ul>
      <div class="centered"><img src="img/consultation-point.jpg" alt="Public constultation point" width="533" height="300" /></div>
    </div>
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint([0, 430, -400]); ?> data-scale="1">
      <ul>
        <li>By building a few devices for hardware tests:
          <ul>
            <li>ballot reader</li>
            <li>ballot burner</li>
            <li>RFID jammer</li>
          </ul>
        (some worked, some didn't)
        </li>
        <li>Lots of internet research (thanks to the leaked source code and photos)</li>
        <li>Great effort</li>
      </ul>
    </div>
    <!-- -->

    <!-- about vot.ar, brief desc -->
		<div class="step anim" <?php $pos->reset_angle(); $pos->shiftprint([0, 1050, 400]); ?> data-scale="1">
      <p><strong>Vot.Ar</strong> a.k.a <strong>BUE</strong> that stands for Unique Electronic Ballot in Spanish, is a paper-based eVoting system by MSA Group.  It has two main elements:</p>
      <ul>
        <li>The vote-casting and counting machine</li>
        <li>The ballot</li>
      </ul>
      <br /><br /><br />
      <p><b class="scaling pastel-red">Most obvious vulnerability?</b></p>
      <p class="footnote pastel-red">among others...</p>
    </div><!-- +(0,0,0) -->
		<div class="step hidden" <?php $pos->printc(); ?> data-scale="1">
      <div class="facepalm">
        <div class="overlay-img-txt txt-tiny pale-yellow">
          <img src="img/facepalm.jpg" alt="facepalm" width="300" height="225" />
          <span>It's RFID based!</span>
        </div>
      </div>
    </div>
    <!-- -->

    <!-- israel case -->
    <div class="step hidden" <?php $pos->shiftprint([1100], ["theta" => -25]); ?> data-scale="1">
      <p>Why is RFID such a bad idea?</p>
      <img src="img/evoting-rfid.jpg" alt="e-voting rfid" width="1050" height="625" />
    </div>
    <!-- -->

    <!-- some details  -->
    <div id="req" class="step anim" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1100]); ?> data-scale="1">
      <h2>Requirements for Vot.Ar (by its patent &amp; law)</h2>
      <ol>
        <li><strong>Universal</strong>*</li>
        <li><strong>Equal</strong>*</li>
        <li class="pastel-red"><strong>Secret</strong>*</li>
        <li><strong>Mandatory</strong>*</li>
        <li>Free (as in freedom)</li>
        <li class="pastel-red">One vote per elector</li>
      </ol>
      <p class="footnote">* Constitutional rights</p>
    </div>

    <div class="step" <?php $pos->shiftprint(["y" => 1000], ["theta" => 10]); ?> data-scale="1">
      <h2>Some things to note about Vot.Ar</h2>
      <ul>
        <li>Completely closed HW &amp; SW (a <em>black box</em> for us).</li>
        <li>Absolutely no public documentation: yet the maker says it's open source!</li>
        <li>Over <strong>7 years of development</strong>:
          <ul>
            <li>Used in Salta (and audited there)</li>
            <li>Recently used in the capital city of Chaco and Neuquén</li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint([1400, 115], ["theta" => 10]); ?> data-scale="1">
      <ul>
        <li>2 official audits by the time of the report (june/july 2015):
          <ul>
              <li>Prof. Righetti, FCEN, UBA: OAT 03/15
              <br /><strong>Conclusion</strong>: <em>small issues, but ok</em>.</li>
              <li>Departamento de Inform&aacute;tica, ITBA: DVT 56-504
              <br /><strong>Conclusion</strong>: <em>inconclusive, recommendations given</em>.</li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint([-1400, 750], ["theta" => -10]); ?> data-scale="1">
      <ul>
        <li>A <strong>serious security flaw</strong> left exposed the SSL certificates that were going to be used for transmitting the results!</li>
        <li>An independent programmer, <a href="https://twitter.com/_joac" class="link">Joaqu&iacute;n Sorianello</a>, reported this flaw to the company, only to get <strong>raided by the police two days before the elections</strong> (he still has a criminal case for reporting the flaw).</li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint(1400, ["theta" => 10]); ?> data-scale="1">
      <ul>
        <li>Also, independent hacks occur, causing leakage of personal data of company technicians, reason why a Judge decides to <a href="http://pastebin.com/gHC89Mh6" class="link-shadow">block</a> the site <a class="link" href="https://justpaste.it">justpaste.it</a> where the info was published.</li>
      </ul>
    </div>

    <!-- -timeline -->
    <div id="timeline" class="step" <?php $pos->reset_angle(); $pos->shiftprint([2800, 1500, 100], ["phi" => 10]); ?> data-scale="3">
      <img src="img/timeline-1.png" alt="Timeline" width="1032" height="780" />
    </div>
    <div class="step" <?php $pos->shiftprint([3100, 548]); ?> data-scale="3">
      <img src="img/timeline-2.png" alt="Timeline" width="1100" height="780" />
    </div>
    <!-- - -->

    <div class="step anim" <?php $pos->set_angle([0, 30, 0]); $pos->shiftprint([2000, 850]); ?> data-scale="2">
      <p><strong>The system reported here is as it was used in this year's elections</strong> in Buenos Aires Autonomous City (CABA)</p>
    </div>
    <!-- -->

    <!-- macro description of the system -->
    <!-- -machine -->
    <div id="macro" class="step" <?php $pos->reset_angle(); $pos->shiftprint([4000, 200]); ?> data-scale="1">
      <h2>Overview of Vot.Ar</h2>
      <div class="overlay-img-txt">
        <img src="img/overview.png" alt="overview" width="600" height="600" />
        <span class="txt-tiny pale-yellow">Portable unit, somewhat bigger than a suitcase</span>
      </div>
    </div>

    <div class="step anim" <?php $pos->shiftprint(-900, ["phi" => -10]); ?> data-scale="1">
      <p>On the left:</p>
      <ul>
        <li>Touch screen for operation<br />(to pick candidates and other functions)</li>
      </ul>
    </div>

    <div class="step anim" <?php $pos->shiftprint(1550, ["phi" => 20]); ?> data-scale="1">
      <p>On the right:</p>
      <ul>
        <li>Ballot slot: an RFID reader/writer + thermal printer unit</li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint([-850, -600], [30, 0, -10]); ?> data-scale="1">
      <p>On the top:</p>
      <ul>
        <li>
        DVD R/W, status LEDs &amp; ports:
        <table>
          <tr>
            <td>
              <ul>
                <li><em>USB *</em></li>
                <li>SVGA</li>
              </ul>
            </td>
            <td>
              <ul>
                <li>Ethernet</li>
                <li>Speaker</li>
              </ul>
            </td>
          </tr>
        </table>
        accessible for everyone, under a small lid
        </li>
      </ul>
      <p class="footnote">* BadUSB?...</p>
    </div>

    <div class="step" <?php $pos->shiftprint([100, 1200], -60); ?> data-scale="1">
      <p>On the bottom:</p>
      <ul>
        <li>a power source + 2 packs of batteries</li>
        <li>sometimes, a JTAG cable!</li>
      </ul>
    </div>
    <!-- - -->

    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 400]); ?> data-scale="1">
      <p>On the other hand there's the ballot, which has an RFID chip + thermal paper on the back.</p>
      <p>Also a die-cutting on one side, to verify that the ballot wasn't swapped.</p>
      <p class="footnote">Details in a moment...</p>
    </div>

    <div class="step" <?php $pos->shiftprint(["y" => 350]); ?> data-scale="1">
      <p>But propaganda said:</p>
      <q>It's a printer, not a computer!</q>
      <p><small>and everybody believed it!</small></p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 320]); ?> data-scale="1">
      <video width="720" height="404" controls>
        <source src="vid/es_una_impresora-sub.webm" type="video/webm">
        Montenegro y Angelini: Es una impresora.
      </video>
    </div>

    <div class="step" <?php $pos->shiftprint(["y" => 960], 10); ?> data-scale="2">
      <div class="overlay-img-txt centered">
        <img src="img/tweeting-machine.png" alt="Tweeting from a Vot.Ar machine" width="1219" height="652" />
        <span class="bottom flag-blue txt-reduced">So here we were, tweeting from a "printer"...</span>
      </div>
    </div>
    <!-- -->

    <!-- electoral process -->
    <!-- -opening station -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1000]); ?> data-scale="1">
      <h2 class="centered">Quick peek: Deployment of Vot.Ar</h2>
      <ul>
        <li>The company provides machines, ballots and a group of technicians per school.</li>
        <li>Technicians have an Id card w/ RFID chip.</li>
      </ul>
    </div>
	  <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 550], ["theta" => 10]); ?> data-scale="1">
	  	<ul>
      	<li class="txt-reduced"><img class="align-left" src="img/dvd-recording.jpg" alt="DVDs recording" width="515" height="399" />The software is recorded during the "DVD recording process", where company representatives altogether with Electoral Authority representatives, party polling authorities and third-party viewers, <em>while magically reviewing the code in a screen</em> then hand over those DVDs to the Electoral Authority.</li>
    	</ul>
  	</div>
    <div class="step" <?php $pos->shiftprint(["y" => 550], ["theta" => 10]); ?> data-scale="1">
    	<ul>
        <li><img class="align-right" src="img/dvd.jpg" alt="DVDs and President Id card" width="500" height="281" />The Electoral Authority provides the software DVD, with a President Id card (w/ RFID chip) and Log-in credentials, in a sealed envelope.</li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 600], ["theta" => -30]); ?> data-scale="1">
      <h2 class="centered">Quick peek: Opening Polling Station</h2>
      <ol>
        <li>Turn on the machine, insert DVD.</li>
        <li><img class="align-right" src="img/screen-calib.jpg" alt="Screen calibration" width="360" height="345" />Follow instructions to calibrate touch screen.</li>
      </ol>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 400], ["theta" => -10]); ?> data-scale="1">
    	<ol start="3">
        <li><img src="img/president-id.jpg" alt="President ID" width="327" height="353" /><br />
          Use President Id card to open a log-in screen, then type in Polling Station number &amp; PIN.</li>
      </ol>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 650], ["theta" => -10]); ?> data-scale="1">
      <ol start="4">
        <li><img class="align-left" src="img/loggedin-screen.jpg" alt="Logged-in Screen" width="622" height="350" />Select the option to open the Polling Station, fill in required data.</li>
        <li>Insert special ballot, that will be printed with the names of the Polling Station Authorities, the time it was opened and a QR code containing that same info.  Also, it will be stored in its chip.</li>
      </ol>
    </div>
    <!-- -->
    <!-- -voting -->
    <div class="step" <?php $pos->shiftprint(1700, 15); ?> data-scale="1">
      <h2 class="centered">Quick peek: Voting</h2>
      <table>
        <tr>
          <td>
            <ol>
              <li>Go to the Polling Table, present Identity Document, and get a ballot:<br />The President will keep a part of the die-cutting of the ballot.</li>
            </ol>
          </td>
          <td>
            <div class="overlay-img-txt centered">
              <img src="img/ballot-front.jpg" alt="Ballot" width="320" height="120" />
              <span class="soft-green">1</span>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <ol start="2">
              <li>With the ballot, go where the machine stands.</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>
            <ol start="3">
              <li>Insert the ballot in the slot.</li>
            </ol>
          </td>
          <td>
            <div class="overlay-img-txt centered">
              <img src="img/inserting-ballot.jpg" alt="Inserting ballot" width="180" height="320" />
              <span class="soft-green">3</span>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 850]); ?> data-scale="1">
      <table>
        <tr>
          <td>
            <ol start="4">
              <li>Pick candidate or list from the screen.</li>
            </ol>
          </td>
          <td>
            <div class="overlay-img-txt centered">
              <img src="img/picking-candidate.jpg" alt="Picking candidate" width="180" height="250" />
              <span class="soft-green">4</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <ol start="5">
              <li>When done, pick the option to vote (prints ballot and stores vote in chip). Remove ballot from slot.</li>
            </ol>
          </td>
          <td>
            <div class="overlay-img-txt centered">
              <img src="img/ballot-back.jpg" alt="Ballot printed" width="320" height="131" />
              <span class="soft-green">5</span>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <ol start="6">
              <li>Approach the ballot to the reader (or insert it into slot again) to verify the vote, bend it over and return to the table.</li>
              <li>The President will verify and remove the second part of the die-cutting.  After that, insert ballot into the ballot box and retrieve your document.</li>
            </ol>
          </td>
        </tr>
      </table>
    </div>
    <!-- - -->
    <!-- -closing -->
    <div class="step" <?php $pos->shiftprint(1800, -15); ?> data-scale="1">
      <h2 class="centered">Quick peek: Closing Station</h2>
      <p>When the voting ends (at 6 PM):</p>
      <ol>
              <li>Log-in as President.</li>
              <li>Insert the Station Opening Ballot.</li>
              <li>Select the option to close the station, set the current time.</li>
              <li>Insert a special ballot that will get printed with similar information as the Station Opening one.</li>
      </ol>
    </div>
    <!-- - -->
    <!-- -scrutiny -->
    <div class="step" <?php $pos->shiftprint(1500, -15); ?> data-scale="1">
      <h2 class="centered">Quick peek: Scrutiny</h2>
      <ol>
              <li>Immediatly after closing, the scrutiny mode is set.</li>
              <li>Pick a ballot from the box, check that it's correctly printed and has no strange marks.</li>
              <li>Approach it to the machine to get it counted.</li>
              <li>Repeat for the entire ballot box.</li>
              <li>When done, insert a special ballot that will get printed with the result of the scrutiny.  Many can be printed, as needed.</li>
      </ol>
    </div>
    <!-- - -->
    <!-- -transmission -->
    <div class="step" <?php $pos->shiftprint(1600, -15); ?> data-scale="1">
      <h2 class="centered">Quick peek: Scrutiny Transmission</h2>
      <ol>
        <li>Connect the machine to the LAN.</li>
        <li>Now, a Scrutiny Transmission Ballot must be inserted to be able to continue.</li>
        <li>???</li>
      </ol>
      <p><em>We weren't able to obtain more information regarding this point</em>.</p>
      <p>The special ballot created didn't worked, hence we were never able to complete this procedure.</p>
    </div>
    <!-- - -->
    <!-- -->

    <!-- HW deep -->
    <!-- -inside, all -->
    <div id="hwdeep" class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 1000]); ?> data-scale="1">
      <h2>Deep into the HW</h2>
      <div class="overlay-img-txt">
        <span class="pale-yellow">What's inside the machine?</span>
        <img src="img/inside.jpg" alt="Inside the machine" width="1000" height="645" />
      </div>
    </div>

    <div class="step" <?php $pos->shiftprint([1200, 300], ["phi" => 25]); ?> data-scale="1">
    <div class="overlay-img-txt">
      <span class="pale-yellow" style="top: 130px;">Deeper inside (behind the screen)</span>
      <img src="img/inside-behind.jpg" alt="Behind the inside of the machine" width="1000" height="735" />
    </div>
    </div>

    <div class="step" <?php $pos->shiftprint([800, 750], ["phi" => 25]); ?> data-scale="1">
      <ul>
        <li>JTAG port: used to program/debug the microcontroller.
    External access via a cable near the batteries.</li>
      </ul>
      <div class="overlay-img-txt centered">
        <img src="img/jtag-elections.jpg" alt="JTAG exposed during elections" width="580" height="435" />
        <span class="soft-green txt-tiny">Some machines had it even during elections!</span>
        <span class="bottom threat">Threat level: <i class="pastel-red">high</i></span><!-- DREAD 9 2 2 1 10 -->
      </div>
      <p class="txt-reduced centered pastel-red">Can be used to reprogram the uC!</p>
      <p class="footnote">More on this at <a class="link" target="_blank" href="https://blog.smaldone.com.ar/2015/07/15/el-sistema-oculto-en-las-maquinas-de-vot-ar">Javier's blog</a>.</p>
    </div>

    <div class="step anim" <?php $pos->shiftprint([-1200, -100], [25, 0, -25]); ?> data-scale="1">
      <ul>
        <li>Microprocessor (uP): Intel(R) Celeron(R) CPU N2930 @ 1.83GHz</li>
        <li>RAM memory: 2GB DDR3 1600</li>
        <li>Microcontroller (uC): Atmel AT91SAM7X256
          <ul>
            <li>Internal E2PROM memory: 256KB <b class="positioning">(!)</b></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- - -->

    <!-- -uC -->
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint(["y" => 800]); ?> data-scale="1">
      <p>So, we found an unknown subsystem:</p>
      <img src="img/secret-uc.png" alt="Secret microcontroller" width="568" height="582" />
    </div>
	  <div class="step anim" <?php $pos->set_angle([0, 0, 10]); $pos->shiftprint([-1000, 400]); ?> data-scale="1">
	  	<img src="img/atmel-datasheet.jpg" alt="ATMEL datasheet" width="942" height="700" />
	  </div>
    <div class="step anim" <?php $pos->shiftprint([1600, -400, 0], ["phi" => -10]); ?> data-scale="1">
      <p>The uC ARM controls the thermal printer and the RFID reader/writer.</p>
      <p>Its internal E2PROM memory is <b class="scaling-right">sufficient to store</b><br />every vote cast and more.</p>
      <p>We know <em>nothing</em>, Jon Snow!</p>
    </div>
    <!-- - -->

    <!-- -ballots -->
    <div class="step" <?php $pos->shiftprint([1300, 400, -150], ["theta" => 10]); ?> data-scale="1">
      <h3>About the ballots (aka BUE cards)</h3>
      <img src="img/ballot.jpg" alt="Ballot" width="820" height="600" />
    </div>

    <div class="step" <?php $pos->shiftprint([1200, 100, -450], ["theta" => 10]); ?> data-scale="2">
      <ul>
        <li>Paperboard with a print on one side, and thermal paper on the other + RFID chip.</li>
        <li>The thin metal layer protects the chip from being read when the ballot is <em>perfectly</em> fold.</li>
      </ul>
    </div>

    <div class="step" <?php $pos->shiftprint([3000, 1000, 0], ["theta" => 10]); ?> data-scale="2">
      <img src="img/patente.jpg" alt="Patente voto electronico" width="1000" height="794" />
    </div>

    <div class="step" <?php $pos->shiftprint([-1900, 1000], [-10, -30]); ?> data-scale="1">
      <h3>The RFID Chip</h3>
      <table class="white-row">
        <tr>
          <th>Brand</th>
          <th>Model</th>
          <th>Mem size (Bytes)</th>
          <th>Note</th>
        </tr>
        <tr>
          <td>NXP</td>
          <td>ICODE SLI SL2ICS20 or SLIX SL2S2002 (ISO 15693)</td>
          <td>112</td>
          <td>has a unique ID code</td>
        </tr>
      </table>
      <table class="white-row">
        <tr>
          <th colspan="3">Tag Categories</th>
        </tr>
        <tr>
          <td>Empty Tag 0x0000</td>
          <td>Vote 0x0001</td>
          <td>MSA Technician 0x0002</td>
        </tr>
        <tr>
          <td>President of the Polling Station 0x0003</td>
          <td>Scrutiny Finalised 0x0004</td>
          <td>Polling Station Open 0x0005</td>
        </tr>
        <tr>
          <td>Demonstration 0x0006</td>
          <td>Scrutiny Transmission 0x007F</td>
          <td></td>
        </tr>
        <tr>
          <td>Virgin Tag 0x0007 (?)</td>
          <td>Addendum 0x007F (?)</td>
          <td>Unknown Tag 0xFFFF (?)</td>
        </tr>
      </table>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 800], 10); ?> data-scale="1">
      <h4>Data structure inside the Tag</h4>
      <code>K1 T2 T1 L1 C4 C3 C2 C1 D1...Dn W1 W2 W3 W4</code>
      <table class="white-row">
        <thead>
          <tr>
            <th>Type</th>
            <th>Desc</th>
            <th>Size (bytes)</th>
            <th>Endianness</th>
            <th>Stored as</th>
            <th>Fixed value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>K</td>
            <td>Token</td>
            <td>1</td>
            <td>-</td>
            <td>HEX</td>
            <td>0x1C</td>
          </tr>
          <tr>
            <td>T</td>
            <td>Tag category</td>
            <td>2</td>
            <td>little-endian</td>
            <td>HEX</td>
            <td>-</td>
          </tr>
          <tr>
            <td>L</td>
            <td>Data lenght</td>
            <td>1</td>
            <td>-</td>
            <td>HEX</td>
            <td>-</td>
          </tr>
          <tr>
            <td>C</td>
            <td>CRC32(Data)</td>
            <td>4</td>
            <td>little-endian</td>
            <td>HEX</td>
            <td>-</td>
          </tr>
          <tr>
            <td>D</td>
            <td>Data</td>
            <td>n</td>
            <td>-</td>
            <td>ASCII</td>
            <td>-</td>
          </tr>
          <tr>
            <td>W</td>
            <td>Write test?</td>
            <td>4</td>
            <td>-</td>
            <td>ASCII</td>
            <td>W_OK</td>
          </tr>
        </tbody>
      </table>
      <p class="footnote">More info about the chip and how data is stored: see IV. B of the report</p>
    </div>
    <!-- - -->
    <!-- -->

    <!-- SW deep-->
    <div id="swdeep" class="step" <?php $pos->reset_angle(); $pos->shiftprint([-1500, 800]); ?> data-scale="1">
      <h2>Time to analyse the SW</h2>
      <p>We were able to do it thanks to the help of someone named <a class="link" target="_blank" href="https://twitter.com/prometheus_ar">Prometheus</a>, who <a class="link-shadow" target="_blank" href="https://github.com/prometheus-ar/vot.ar/">published the source code</a>.<p>
      <ul>
        <li>Written in Python.</li>
        <li>A <i>live-dvd</i> is used:
          <ul>
            <li>Linux Ubuntu-based (a little bit trimmed).</li>
            <li>Hash file/contents <em>not cryptographically signed</em> (DVD can be changed at any moment).</li>
            <li>UEFI/SecureBoot not implemented.</li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 650]); ?> data-scale="1">
      <video width="720" height="404" controls>
        <source src="vid/angelini-sub.webm" type="video/webm">
        Your browser doesn't support the video type.  Desc: Angelini about the machine
      </video>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 540]); ?> data-scale="1">
      <ul>
        <li>The program runs as <em>root</em>.</li>
        <li>Log-in credentials are hardcoded in .json file.</li>
        <li>Completely lacks of (public) documentation and in-code documentation.</li>
        <li>Very few comments, some where wrong.</li>
        <li>Untidy code.</li>
        <li>No unit testing.</li>
      </ul>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 360]); ?> data-scale="1">
      <p>This makes the code hard to read, audit, maintain, improve...</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 125], 180); ?> data-scale="1">
      <p>...but ideal to breed nasty bugs...</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 125], -180); ?> data-scale="1">
      <p>...such as <b class="scaling">#multivote</b> and others...</p>
    </div>

    <!-- -command injection -->
    <div id="commi" class="step" <?php $pos->shiftprint([1200, -100, 1500], ["theta" => 90]); ?> data-scale="1">
      <h2>Command injection</h2>
      <p>Alfredo Ortega found a command injection vulnerability in the QR Code generator routine.</p>
      <ol>
        <li>msa/core/clases.py, line 190: <code>a_qr_str()</code> returns a comma-separated list of values.</li>
        <li>msa/core/clases.py, line 206: <code>a_qr()</code> sends those values to the vulnerable function.</li>
        <li>msa/core/qr.py, line 13: <code>crear_qr()</code> <strong>vulnerable function</strong>, executes the command without sanitising first.</li>
      </ol>
    </div>
	  <div class="step" <?php $pos->shiftprint([200, 800], -25); ?> data-scale="1">
			<img src="img/ci-code.jpg" alt="Command Injection Code" width="623" height="600" />
    </div>

    <div class="step" <?php $pos->shiftprint(["y" => 900], 25); ?> data-scale="1">
      <p>This routine is executed to print the QR code of the names of the President of the Polling Station and Party Polling Authorities.</p>
      <ul>
        <li>Nombre: <pre>Juan</pre></li>
        <li>Apellido: <pre>Perez;echo 'this is bad!'</pre></li>
      </ul>
      <p class="txt-reduced">The name input screen does sanitise and has a length limit, so exploiting this is complicated.</p>
      <p class="centered threat">Threat level: <i class="medium-orange">medium</i></p>
    </div><!-- DREAD 3 1 8 1 10 -->
    <!-- - -->

    <!-- -multivote -->
    <div id="multivote" class="step" <?php $pos->shiftprint([400, 1200, 800], ["theta" => -180]); ?> data-scale="2">
      <h2>Multivote</h2>
      <p>This vulnerability allows an attacker to <strong class="pastel-red">add several votes</strong> to the RFID chip, as many as the chip's memory amount supports (about <strong>10~12 votes</strong>).</p>
      <p>Also, it's <em>not mandatory to distribute the votes in any way</em>: they can be for a single candidate, or split among several candidates, in the same or different electoral category.</p>
      <p class="centered threat">Threat level: <i class="critical-purple">critical</i> (CVE-2015-6839)</p><!-- DREAD 9 8 3 10 10 -->
    </div>
    <div class="step" <?php $pos->shiftprint([400, 1200, 0]); ?> data-scale="1">
    	<img src="img/multivote.jpg" alt="Multivote" width="620" height="700" />
    </div>
    <div class="step" <?php $pos->shiftprint([-400, -1500, -1500],["theta" => 10]); ?> data-scale="1">
      <p>You <em>cannot differentiate</em> between a <em>multivote ballot</em> and a <em>normal one</em> with a naked eye.</p>
      <p>So, an attacker with access to a thermal printer and blank ballots (not too hard to get) <em>could cast fake votes beforehand</em> that are very hard to detect.</p>
      <p>An attacker could also use adhesive rfid tags, and create the multivote with a mobile phone.</p>
      <p>It was recognized by Prof. Righetti's latest audit (but it's importance was diminished).</p>
    </div>
    <div class="step" <?php $pos->shiftprint([-800, 0, -1200]); ?> data-scale="1">
    	<p>The vulnerable method is <code>desde_string</code> belonging to the class <code>Seleccion</code> in <i>msa/core/clases.py</i></p>
    	<h3>Pseudocode</h3>
    	<img src="img/multivote-pseudo.jpg" alt="Multivote pseudocode" width="450" height="327" />
    </div>
    <div class="step" <?php $pos->shiftprint([-800, 0, -1200], ["theta" => 10]); ?> data-scale="1">
      <h4>Multivoting is easy, one just needs to build a vote string</h4>
      <p>This would be a normal vote for  "Representative" (DIP), "Mayor"
    (JEF) and "Commune Chief" (COM) for the Autonomous City of Buenos Aires (CABA): <code>06CABA.1COM567DIP432JEF123</code>.</p>
      <p>And this would be a <i>multivote</i> string: <code>06CABA.1JEF123JEF123JEF123COM567DIP432</code> where the Mayor got <em>three votes</em> and the rest of the categories, one.</p>
      <p class="footnote">See point IV. B. 1 and Appendix B. C of the report</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 810]); ?> data-scale="1">
      <p>For example, it's possible to find some info online, at the electoral authority's website:</p>
      <div class="centered">
        <img src="img/login-json-online.jpg" alt="https://www.eleccionesciudad.gob.ar/simulador/datos/" width="511" height="300" />
        <img src="img/candidatos-json-online.jpg" alt="https://www.eleccionesciudad.gob.ar/simulador/datos/CABA/Candidatos.json" width="360" height="600" class="right" />
      </div>
    </div>
    <!-- - -->

    <!-- -bypassing log-in -->
    <div id="bypass" class="step" <?php $pos->reset_angle(); $pos->shiftprint([-1200, 800]); ?> data-scale="1">
      <h2>Bypassing log-in screen</h2>
      <h3>Impersonating Technician or President of the Polling Station</h3>
      <p class="right">This is trivial, since <em>no authentication</em> is used with the chip's data.</p>
      <p>Get some spare RFID chips and:</p>
      <ol>
        <li>Craft a fake <i>Polling Station Open</i> ballot.</li>
        <li>Craft a <i>President of the Polling Station</i> ballot.</li>
        <li>Craft a <i>Technician</i> ballot.</li>
      </ol>
    </div>
    <div class="step" <?php $pos->shiftprint([-200, 1100, 50]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/start-screen.jpg" alt="Home Screen" width="711" height="400" />
        <span>Use the President ballot to pop up<br />the log-in screen</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([1800, 250], ["theta" => -25]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/login-screen.jpg" alt="Log-in Screen" width="711" height="400" />
        <span>Use the Polling Station Open ballot <br />to bypass PIN entry</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([1400, 450, 150], ["theta" => -25]); ?> data-scale="2">
      <div class="overlay-img-txt txt-reduced centered flag-blue">
        <img src="img/loggedin-screen.jpg" alt="Logged-in Screen" width="711" height="400" />
        <span>Logged-in!</span>
      </div>
    </div>
    <div class="step" <?php $pos->shiftprint([700, 100, 1300], ["theta" => -25]); ?> data-scale="1">
      <div class="overlay-img-txt txt-reduced pale-yellow">
        <img src="img/maintenance-screen.jpg" alt="Maintenance screen" width="900" height="566" />
        <span>Now use the Technician ballot and access<br/>
        maintenance mode</span>
      </div>
      <p class="centered threat">Threat level: <i class="pastel-red">high</i></p><!-- DREAD 5 10 8 1 10 -->
      <p class="txt-reduced">Allows DVD ejection &amp; some DoS.  Another evidence of a bad design...</p>
    </div>
    <!-- - -->
    <!-- -->

    <!-- bue vs bup -->
    <div id="buebup" class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1800]); ?> data-scale="1">
      <h2 class="centered">A few words about Unique Paper Ballot</h2>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => 500]); ?> data-scale="1">
      <img src="img/bue-voto-economia.jpg" alt="voto economia" width="433" height="600" />
      <p class="footnote">Infographics by <a class="link" href="https://twitter.com/rusosnith">Andres Snitcofsky</a>.</p>
    </div>
    <div class="step" <?php $pos->shiftprint(["y" => -46], ["theta" => 90]); ?> data-scale="1">
      <img src="img/bue-bateria.jpg" alt="bateria" width="433" height="600" />
    </div>
    <div class="step" <?php $pos->shiftprint(["z" => -600]); ?> data-scale="1">
      <img src="img/bue-dvds.jpg" alt="dvds" width="433" height="600" />
    </div>
    <div class="step" <?php $pos->shiftprint([600, 0, 600], ["theta" => -90]); ?> data-scale="1">
      <img src="img/bue-boleta.jpg" alt="boleta" width="433" height="600" />
    </div>
    <div class="step" <?php $pos->reset_angle(); $pos->shiftprint([0, 1000, 600]); ?> data-scale="1">
      <p class="txt-reduced centered"><strong>BUE</strong> stands for Unique Electronic Ballot and <strong>BUP</strong> for Unique Paper Ballot (in Spanish)<p>
      <table class="white-row">
        <thead>
          <tr>
            <th>BUE</th>
            <th>BUP</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2">Both: better than traditional (french) system</td>
          </tr>
          <tr>
            <td>~U$D 9 per vote</td>
            <td>~U$D 2 per vote</td>
          </tr>
          <tr>
            <td>1.84Kg of batteries per machine * 9k machines = 16.5Ton!</td>
            <td>No batteries needed</td>
          </tr>
          <tr>
            <td>Ballots hard to recycle</td>
            <td>Easily reciclable</td>
          </tr>
          <tr>
            <td>1 DVD per machine... what do we do with them? Coasters?</td>
            <td>No DVDs required</td>
          </tr>
          <tr>
            <td>Provisional scrutiny faster than manual (~30%)</td>
            <td>Manual provisional scrutiny, but could be automated</td>
          </tr>
          <tr>
            <td>It is eVoting</td>
            <td>It is not eVoting</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- -->

    <!-- bying votes and stuff... -->
    <div class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1000]); ?> data-scale="1">
      <h2>Old threats updated</h2>
      <h4>Some common attacks against electoral systems</h4>
      <ul>
        <li>"Pregnant" ballot box</li>
        <li>President of the Polling Station in favor of a party</li>
        <li>Chain-voting</li>
        <li>Clientelism</li>
        <li>Ballot-stealing</li>
        <li>Ballot-changing</li>
        <li>Interfering delivery of the scrutiny result</li>
      </ul>
      <p class="footnote">Much more detailed explanation <a class="link" target="_blank" href="https://blog.smaldone.com.ar/2015/09/04/boleta-unica-versus-boleta-unica-electronica/">by Javier</a>.</p>
    </div>
    <div class="step" <?php $pos->shiftprint([1300, 100], ["phi" => 10]); ?> data-scale="1">
      <p>There's <b>no major advantage</b> between BUP and BUE on any point.</p>
      <p class="txt-reduced">(so, no improvements from a simple sheet of paper?)</p>
      <br />
      <p>Yet, <b>BUE introduces an improved way to buy votes</b>, that can be exploited by <em>point men</em> (political bosses).</p>
    </div>
    <div class="step" <?php $pos->shiftprint([1300, 200], ["phi" => 10]); ?> data-scale="1">
      <p>It's plain easy to hide a mobile phone under the clothes with an app reading the contents of the chip:</p>
      <img src="img/point-men.jpg" alt="Buying votes" width="851" height="450" />
      <p class="footnote">Thanks to <a class="link" href="https://twitter.com/autopolitics" target="_blank">Trist&aacute;n Grimaux</a> for the app - <a class="link" href="https://github.com/tristangrimaux/CardReaderVotar" target="_blank">Get the code!</a></p>
    </div>
    <!-- -->

    <!-- international -->
		<div class="step" <?php $pos->set_angle([-30, 0, 0]); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1200]); ?> data-scale="1">
      <img src="img/world-evoting-map.png" alt="eVoting around the world" width="817" height="600" />
      <p class="footnote"><a class="link-shadow" target="_blank" href="https://www.ndi.org/e-voting-guide/electronic-voting-and-counting-around-the-world">Reference</a></p>
		</div>
    <!-- -->

  	<!-- summary -->
		<div id="summary" class="step" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 1500]); ?> data-scale="2">
			<h1 style="text-align: center;">Summing up...</h1>
      <ul>
        <li>Bad programing technics lead to <span class="pastel-red">vulns</span>.</li>
        <li>Awfull choice of vote support/storage system.</li>
        <li>Doesn't fullfil <a href="#req" class="link-shadow">requirements:</a>
          <ul>
            <li><em>Violates</em> the secrecy of the vote.</li>
            <li><em>More than one</em> vote per elector.</li>
            <li>It's <em>obscure</em> for the voter (and everyone else).</li>
          </ul>
        </li>
        <li>No significant advantages compared to the Unique Paper Ballot system.</li>
      </ul>
		</div>
		<div class="step" <?php $pos->shiftprint(2500, 45); ?> data-scale="2">
      <p>As the General Court in Germany ruled, according to its Constitution:</p>
      <blockquote>When electronic voting machines are deployed, <strong>it must be possible for the citizen</strong> to <strong>check the essential steps in the election act</strong> and in the ascertainment of the results reliably and <strong>without special expert knowledge</strong>.</blockquote>
      <!--<p class="footnote"><a class="link-shadow" target="_blank" href="http://www.bundesverfassungsgericht.de/SharedDocs/Entscheidungen/EN/2009/03/cs20090303_2bvc000307en.html">Reference</a></p>-->
		</div>
    <!-- -->

    <!-- conclusions -->
    <div id="conclusions" class="step anim slide" <?php $pos->reset_angle(); $pos->shiftprint([3000, 50, 50]); ?> data-scale="3">
			<h1 style="text-align: center;">Conclusion</h1>
      <p>After all we saw:</p>
      <ul>
        <li>Do you really <em>believe</em> it's a <i>printer</i>?</li>
        <li>Uncertainty of election result without manual scrutiny (so what do we need this system for?)</li>
        <li>Risks introduced by eVoting are greater than its benefits</li>
        <li><strong>No technical progress should undermine democracy</strong></li>
      </ul>
      <br />
      <p><b class="positioning">We conclude that this system doesn't comply with its objectives and introduces risks to the electoral process</b></p>
		</div>
    <!-- -->

    <!-- questions -->
		<div class="step slide" <?php $pos->reset_angle(); $pos->set_coord(["z" => 0]); $pos->shiftprint(["y" => 2000]); ?> data-scale="2">
			<h1 style="text-align: center;">Questions?</h1>
      <p>I hope you've enjoyed this presentation!.  Ask whatever you want, there are <em>no restrictions</em>*.</p>
      <p>I propose some:</p>
      <ul>
        <li>How come none of the audits have found these problems?</li>
        <li>Did MSA solve these issues?</li>
        <li>Known attacks against RFID?</li>
        <li>How do you compare it with the brazilian system?</li>
        <li>You mentioned BadUSB... what about it?</li>
        <li>What changes would you propose to this Vot.Ar system?</li>
      </ul>
      <p class="footnote">* Some restrictions may apply</p>
		</div>
    <!-- -->

    <!-- thanks -->
		<div class="step anim slide" <?php $pos->shiftprint(1600); ?> data-scale="1">
			<h1 style="text-align: center;">Thanks for listening!</h1>
			<p>Also, I want to <b class="scaling">thank everybody</b> who supported us:</p>
      <ul>
        <li class="txt-reduced"><span class="soft-green">CaFeLUG</span> (Sergio Aranda Peralta, Ximena García, Lucas Lakousky, Juan Muguerza, Eugenia Núñez, Sergio Orbe, Andrés Paul)</li>
        <li class="txt-reduced"><span class="soft-green">Fundación Via Libre</span></li>
        <li class="txt-reduced"><span class="soft-green">Julio L&oacute;pez</span> and <span class="soft-green">Trist&aacute;n Grimaux</span></li>
        <li class="txt-reduced">Our <span class="soft-green">friends</span> that are always there...</li>
      </ul>
      <p>And the <span class="soft-green">WTE SBSeg organisers</span> for providing a place to share:</p>
      <ul>
        <li class="txt-reduced">Jeroen van de Graaf, Diego de Freitas Aranha, Michelle Wangham, Joni Fraga, and all of the people involved in the organization</li>
      </ul>
      <p><em>Very special thanks to Diego and Jeroen</em> who invited me here!</p>
		</div>
    <!-- -->

    <!-- goodbye -->
		<div id="last" class="step slide" <?php $pos->shiftprint(1100); ?> data-scale="1">
			<h1 style="text-align: center;">More information?</h1>
			<br />
			<p>You can get the full report, this presentation and more at the git repo:</p>
      <p class="right txt-verybig"><a class="link" target="_self" href="https://bit.ly/votar-report">bit.ly/votar-report</a></p>
      <br />
      <p>Feel free to share! (CC BY-SA v4.0).</p>
      <br /><br /><br />
			<p class="footnote">Powered by <a class="link-shadow" target="_blank" href="https://github.com/bartaz/impress.js">impress.js</a></p>
		</div>
    <!-- -->

    <!-- overview -->
    <?php
      if ($show_overview) {
        $pos->autoset_overview();
        $pos->print_overview();
      }
    ?>
    <!-- -->
	</div>

  <!-- impress code -->
  <!-- -hint -->
	<div class="hint">
		<p>Use the arrow keys to move forward/backward</p>
	</div>
	<script>
		if ("ontouchstart" in document.documentElement) {
		document.querySelector(".hint").innerHTML = "<p>Touch the right side of the screen to move forward</p>";
		}
	</script>
  <!-- - -->

	<script src="js/impress.js"></script>
	<script>impress().init();</script>
  <!-- -->
</body>
</html>
