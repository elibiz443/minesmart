<?php

function forecastRisk($current, $velocity, $time_factor) {
  return min(100, $current + ($velocity * $time_factor));
}
