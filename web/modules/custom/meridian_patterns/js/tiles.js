/**
 * Tiles mosaic — shuffle the non-fixed tiles in place. Reduced-motion aware
 * (no animation; instant reorder). Vanilla, no dependencies.
 */
(function (Drupal) {
  Drupal.behaviors.meridianTiles = {
    attach: function (context) {
      context.querySelectorAll('[data-shuffle]').forEach(function (btn) {
        if (btn.dataset.bound) { return; }
        btn.dataset.bound = '1';
        btn.addEventListener('click', function () {
          var grid = btn.closest('[data-tiles]');
          if (!grid) { return; }
          var movable = Array.prototype.filter.call(grid.children, function (el) {
            return !el.hasAttribute('data-tile-fixed');
          });
          // Fisher–Yates over the movable tiles, then re-append in new order.
          for (var i = movable.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var tmp = movable[i]; movable[i] = movable[j]; movable[j] = tmp;
          }
          movable.forEach(function (el) { grid.appendChild(el); });
        });
      });
    }
  };
})(Drupal);
